<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Head;
use App\Models\Area;
use App\Models\Allocation;
use App\Libraries\Common;
use DB;
use Config;
use Session;
use PDF;
use Excel;

class AllocationSummaryReportController extends Controller {

    private $viewFolderPath = 'budget_report/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the allocation Summary.
     *
     * @return head allocation Summary
     */
    public function index(Request $request) {
        $data[] = '';
        $data['account_allocation_summary'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['grand_total_allocation'] = 0;
        $data['all_area_sctor_head_total_allocation'] = 0;
        $data['all_area_sctor_project_head_total_allocation'] = 0;
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);
        if ($request->isMethod('POST') && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = isset($request->area_row_id) ? $request->area_row_id : -1;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $area_row_id;
            $data['selected_budget_year'] = $budget_year;
            $data['account_allocation_summary'] = $common_model->getAllocationSummary($budget_year, $area_row_id);
            if ($area_row_id < 0) {
                $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                $sector_head_list = $common_model->getSectorHeadList();
                $data['all_area_sctor_head_total_allocation'] = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_head_list);
                $sector_project_head_list = $common_model->getSectorProjectHeadList($budget_year);
                $data['all_area_sctor_project_head_total_allocation'] = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_project_head_list);
            }
        }
        return view($this->viewFolderPath . 'budget_allocation_summary_report', ['data' => $data]);
    }

    /**
     * allocation Summary Report PDF Download
     * @param Request $request
     */
    public function allocationSummaryReportPdfDownload(Request $request) {
        $data[] = '';
        $data['account_allocation_summary'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['grand_total_allocation'] = 0;
        $data['all_area_sctor_head_total_allocation'] = 0;
        $data['all_area_sctor_project_head_total_allocation'] = 0;
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);
        if ($request->isMethod('GET') && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = isset($request->area_row_id) ? $request->area_row_id : -1;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $area_row_id;
            $data['selected_budget_year'] = $budget_year;
            $data['account_allocation_summary'] = $common_model->getAllocationSummary($budget_year, $area_row_id);
            if ($area_row_id < 0) {
                $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                $sector_head_list = $common_model->getSectorHeadList();
                $data['all_area_sctor_head_total_allocation'] = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_head_list);
                $sector_project_head_list = $common_model->getSectorProjectHeadList($budget_year);
                $data['all_area_sctor_project_head_total_allocation'] = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_project_head_list);
            }
        }
        $pdf = PDF::loadView($this->viewFolderPath . 'budget_allocation_summary_report_pdf', ['data' => $data]);
        return $pdf->stream('budget_allocation_summary_report.pdf');
    }

    public function downloadAllocationSummaryReportCsv(Request $request) {
        $account_allocation_summary = '';
        $grand_total_allocation = 0;
        $all_area_sctor_head_total_allocation = 0;
        $all_area_sctor_project_head_total_allocation = 0;
        $common_model = new Common();
        if ($request->isMethod('GET') && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = isset($request->area_row_id) ? $request->area_row_id : -1;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $account_allocation_summary = $common_model->getAllocationSummary($budget_year, $area_row_id);
            if ($area_row_id == -1) {
                $grand_total_allocation = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                $sector_head_list = $common_model->getSectorHeadList();
                $all_area_sctor_head_total_allocation = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_head_list);
                $sector_project_head_list = $common_model->getSectorProjectHeadList($budget_year);
                $all_area_sctor_project_head_total_allocation = $common_model->getSectorHeadTotalAllocation($budget_year, -1, $sector_project_head_list);
            }
            if ($account_allocation_summary) {
                $serial = 0;
                foreach ($account_allocation_summary as $area_row_id_key => $area_allocation_row) {
                    ++$serial;
                    $a['Serial'] = $serial;
                    $a['Area'] = $area_allocation_row['area_name'];
                    $a['Sector Head(Include Unforeseen)'] = number_format($area_allocation_row['sector_head_allocation'], 2);
                    $a['Project Cost'] = number_format($area_allocation_row['project_head_allocation'], 2);
                    $a['Total'] = number_format($area_allocation_row['total_allocation'], 2);
                    $data[] = (array) $a;
                }
                if ($area_row_id == -1) {
                    $total['Serial'] = "Total";
                    $total['Area'] = "All Areas";
                    $total['Sector Head(Include Unforeseen)'] = number_format($all_area_sctor_head_total_allocation, 2);
                    $total['Project Cost'] = number_format($all_area_sctor_project_head_total_allocation, 2);
                    $total['Total'] = number_format($grand_total_allocation, 2);
                    $data[] = (array) $total;
                    $grand_total['Serial'] = "Grand Total";
                    $grand_total['Area'] = "Existing Estb and Projects";
                    $grand_total['Sector Head(Include Unforeseen)'] = number_format($grand_total_allocation, 2);
                    $grand_total['Project Cost'] = '';
                    $grand_total['Total'] = '';
                    $data[] = (array) $grand_total;
                }
                if ($area_row_id > 0):
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $area_name = str_replace(" ", "_", $area_row->title) . "_" . $budget_year;
                else:
                    $area_name = "All_Area_" . $budget_year;
                endif;
                $allocation_list = $data;
                $this->exportAllocationSummaryReportToCsv($allocation_list, $area_name);
            }
        }
    }

    public function exportAllocationSummaryReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
