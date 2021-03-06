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

class AdjustmentReportController extends Controller {

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
     * Show the head adjustment List.
     *
     * @return head adjustment list object
     */
    public function index(Request $request) {
        $data[] = '';
        $data['grand_total_reception'] = 0;
        $data['grand_total_donation'] = 0;
        $data['account_adjustment_list'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['total_reception_by_area'] = '';
        $data['total_donation_by_area'] = '';
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
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    /**
                     * Calculate grand total
                     */
                    $data['grand_total_reception'] = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $data['grand_total_donation'] = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $data['total_reception_by_area'] = $total_reception_by_area;
            $data['total_donation_by_area'] = $total_donation_by_area;
            $data['account_adjustment_list'] = $common_model->allocationFilterHeads(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            //dd($data['account_adjustment_list']);
        }
        return view($this->viewFolderPath . 'budget_adjustment_report', ['data' => $data]);
    }

    /**
     * Expense Report PDF Download
     * @param Request $request
     */
    public function adjustmentReportPdfDownload(Request $request) {
        $data[] = '';
        $data['grand_total_reception'] = 0;
        $data['grand_total_donation'] = 0;
        $data['account_adjustment_list'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['total_reception_by_area'] = '';
        $data['total_donation_by_area'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allMainHeads();
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
            $area_row_detail = $common_model->get_area_row_info($area_row_id);
            $data['area_row_detail'] = $area_row_detail;
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
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    /**
                     * Calculate grand total
                     */
                    $data['grand_total_reception'] = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $data['grand_total_donation'] = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $data['total_reception_by_area'] = $total_reception_by_area;
            $data['total_donation_by_area'] = $total_donation_by_area;
            $data['account_adjustment_list'] = $common_model->allocationFilterHeads(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
        }
        $pdf = PDF::loadView($this->viewFolderPath . 'budget_adjustment_report_pdf', ['data' => $data]);
        return $pdf->stream('budget_adjustment_report.pdf');
    }

    public function downloadAdjustmentReportCsv(Request $request) {
        $account_adjustment_list = '';
        $common_model = new Common();
        $alphabets = $common_model->alphabet_array;
        $roman = $common_model->roman_array;
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
            /**
             * If all Head selected then count grand total by area wise
             */
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                } else {
                    /**
                     * Calculate grand total
                     */
                    $grand_total_reception = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $grand_total_donation = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                }
            }
            $account_adjustment_list = $common_model->allocationFilterHeads(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            if ($account_adjustment_list) {
                $parent_serial = 1;
                foreach ($account_adjustment_list as $area_row_id_key => $area_allocation_row) {
                    foreach ($area_allocation_row as $adjustment_row) {
                        $a = array();
                        $head_serial_number = $parent_serial . ". ";
                        $parent_serial++;
                        $a['Head Name'] = $head_serial_number . $adjustment_row['title'];
                        $a['Area Name'] = $area_row_id_key;
                        if (isset($adjustment_row['head_total_donation']) && !empty($adjustment_row['head_total_donation'])) {
                            $a['Donate)'] = number_format($adjustment_row['head_total_donation'], 2);
                        } else {
                            $a['Donate'] = number_format(0.00, 2);
                        }
                        if (isset($adjustment_row['head_total_adjustment']) && !empty($adjustment_row['head_total_adjustment'])) {
                            $a['Receive)'] = number_format($adjustment_row['head_total_adjustment'], 2);
                        } else {
                            $a['Receive'] = number_format(0.00, 2);
                        }
                        $data[] = (array) $a;
                    }
                    if ($head_row_id == -1):
                        $area_total['Head Name'] = "Total( " . $area_row_id_key . " )";
                        $area_total['Area Name'] = $area_row_id_key;
                        $area_total['Donate'] = number_format($total_donation_by_area[$area_row_id_key], 2);
                        $area_total['Receive'] = number_format($total_reception_by_area[$area_row_id_key], 2);
                        $data[] = (array) $area_total;
                    endif;
                    $parent_serial = 1;
                }
                if (($head_row_id == -1) && ($area_row_id == -1)):
                    $all_area_total['Head Name'] = "Grand Total( All Areas )";
                    $all_area_total['Area Name'] = "All Areas";
                    $all_area_total['Donate'] = number_format($grand_total_donation, 2);
                    $all_area_total['Receive'] = number_format($grand_total_reception, 2);
                    $data[] = (array) $all_area_total;
                endif;
            }
            if ($area_row_id > 0):
                $area_row = $common_model->get_area_row_info($area_row_id);
                $area_name = str_replace(" ", "_", $area_row->title) . "_" . $budget_year;
            else:
                $area_name = "All_Area_" . $budget_year;
            endif;
            $data['adjustment_list'] = $data;
            $this->exportAdjustmentnReportToCsv($data['adjustment_list'], $area_name);
        }
    }

    public function exportAdjustmentnReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
