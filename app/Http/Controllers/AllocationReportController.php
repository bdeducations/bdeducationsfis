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

class AllocationReportController extends Controller {

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
     * Show the head allocation List.
     *
     * @return head allocation list object
     */
    public function index(Request $request) {
        $data[] = '';
        $data['account_allocation_list'] = '';
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['grand_total_allocation'] = 0;
        $data['total_allocation_by_area'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allMainHeads();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        if ($request->isMethod('POST') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && !empty($to_date)) {
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $data['from_date'] = $to_date;
                $data['to_date'] = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            /**
             * If all Head selected then count grand total by area wise
             */
            $total_allocation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, $from_date, $to_date);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $data['total_allocation_by_area'] = $total_allocation_by_area;
            $data['account_allocation_list'] = $common_model->allocationFilterHeads(0, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            //dd($data['account_allocation_list']);
        }
        return view($this->viewFolderPath . 'budget_allocation_report', ['data' => $data]);
    }

    public function allocationReportDetails(Request $request) {
        $data[] = '';
        $data['grand_total_allocation'] = 0;
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['area_details_row'] = '';
        $data['head_name'] = '';
        $data['allocation_list'] = '';
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && !empty($to_date)) {
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $data['from_date'] = $to_date;
                $data['to_date'] = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            if ($area_row_id > 0) {
                $area_row = $common_model->get_area_row_info($area_row_id);
                $data['area_details_row'] = $area_row;
            }
            $data['allocation_list'] = $common_model->getAllocationDetailsList($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            $data['head_name'] = $common_model->getHeadAncestorHierarchy($head_row_id);
        }
        return view($this->viewFolderPath . 'budget_allocation_report_details', ['data' => $data]);
    }

    public function allocationReportDetailsPdfDownload(Request $request) {
        $data[] = '';
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['area_details_row'] = '';
        $data['head_name'] = '';
        $data['allocation_list'] = '';
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && !empty($to_date)) {
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $data['from_date'] = $to_date;
                $data['to_date'] = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            if ($area_row_id > 0) {
                $area_row = $common_model->get_area_row_info($area_row_id);
                $data['area_details_row'] = $area_row;
            }
            $data['allocation_list'] = $common_model->getAllocationDetailsList($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            $data['head_name'] = $common_model->getHeadAncestorHierarchy($head_row_id);
        }
        $pdf = PDF::loadView($this->viewFolderPath . 'budget_allocation_report_details_pdf', ['data' => $data]);
        return $pdf->stream('budget_allocation_report_detail_pdf.pdf');
    }

    /**
     * Expense Report PDF Download
     * @param Request $request
     */
    public function allocationReportPdfDownload(Request $request) {
        $data[] = '';
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['total_allocation_by_area'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            if ($area_row_id > 0) {
                $data['area_number_count'] = 1;
            } else {
                $data['area_number_count'] = $common_model->area_number_count();
            }
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $area_row_detail = $common_model->get_area_row_info($area_row_id);
            $data['area_row_detail'] = $area_row_detail;
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && !empty($to_date)) {
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $data['from_date'] = $to_date;
                $data['to_date'] = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            /**
             * If all Head selected then count grand total by area wise
             */
            $total_allocation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, $from_date, $to_date);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $data['total_allocation_by_area'] = $total_allocation_by_area;
            $data['account_allocation_list'] = $common_model->allocationFilterHeads(0, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
        }
        //return view($this->viewFolderPath . 'budget_allocation_report_pdf', ['data' => $data]);
        $pdf = PDF::loadView($this->viewFolderPath . 'budget_allocation_report_pdf', ['data' => $data]);
        return $pdf->stream('budget_allocation_report_pdf.pdf');
    }

    public function downloadAllocationReportCsv(Request $request) {
        $account_allocation_list = '';
        $total_allocation_by_area = array();
        $common_model = new Common();
        $alphabets = $common_model->alphabet_array;
        $roman = $common_model->roman_array;
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            if ($area_row_id > 0) {
                $area_number_count = 1;
            } else {
                $area_number_count = $common_model->area_number_count();
            }
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            /**
             * If all Head selected then count grand total by area wise
             */
            if ($head_row_id == -1) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    $grand_total_allocation = $common_model->getTotalAllocation(-1, $budget_year, $from_date, $to_date);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $account_allocation_list = $common_model->allocationFilterHeads(0, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            if ($account_allocation_list) {
                $head_serial_number = '';
                $parent_serial = 1;
                foreach ($account_allocation_list as $area_row_id_key => $area_allocation_row) {
                    foreach ($area_allocation_row as $allocation_row) {
                        $head_serial_number = $parent_serial . ". ";
                        $parent_serial++;
                        $a['Head Name'] = $head_serial_number . $allocation_row['title'];
                        $a['Area Name'] = $area_row_id_key;
                        if (isset($allocation_row['head_total_allocation']) && ($allocation_row['head_total_allocation'] != 0)) {
                            $a['Allocation'] = number_format($allocation_row['head_total_allocation'], 2);
                        } elseif (isset($allocation_row['head_total_allocation']) && ($allocation_row['head_total_allocation'] == 0)) {
                            $a['Allocation'] = 0.00;
                        } else {
                            $a['Allocation'] = '';
                        }
                        $data[] = (array) $a;
                        $parent_serial = 1;
                    }
                    if ($head_row_id == -1):
                        $area_total['Head Name'] = "Total( " . $area_row_id_key . " )";
                        $area_total['Area Name'] = $area_row_id_key;
                        $area_total['Allocation'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                        $data[] = (array) $area_total;
                    endif;
                }
                if (($head_row_id == -1) && ($area_row_id == -1)):
                    $all_area_total['Head Name'] = "Grand Total( All Areas )";
                    $all_area_total['Area Name'] = "All Areas";
                    $all_area_total['Allocation'] = number_format($grand_total_allocation, 2);
                    $data[] = (array) $all_area_total;
                endif;
                if ($area_row_id > 0):
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $area_name = str_replace(" ", "_", $area_row->title) . "_" . $budget_year;
                else:
                    $area_name = "All_Area_" . $budget_year;
                endif;
                $data['allocation_list'] = $data;
                $this->exportAllocationReportToCsv($data['allocation_list'], $area_name);
            }
        }
    }

    public function downloadAllocationDetailsReportCsv(Request $request) {
        $common_model = new Common();
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
            } else {
                $from_date = 0;
                $to_date = 0;
            }
            $allocation_list = $common_model->getAllocationDetailsList($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            $head_name = $common_model->getHeadAncestorHierarchy($head_row_id);
            if ($allocation_list) {
                foreach ($allocation_list as $allocation_row) {
                    $a['Head Name'] = $head_name;
                    $a['Amount'] = number_format($allocation_row->amount, 2);
                    $a['Allocation At'] = date('F j, Y', strtotime($allocation_row->allocation_at));
                    $data[] = (array) $a;
                }
            }
            if ($area_row_id > 0):
                $area_row = $common_model->get_area_row_info($area_row_id);
                $area_name = $area_row->title . "_" . $budget_year;
            else:
                $area_name = "All_Area_" . $budget_year;
            endif;
            $data['allocation_list'] = $data;
            $this->exportAllocationReportToCsv($data['allocation_list'], $area_name);
        }
    }

    public function exportAllocationReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
