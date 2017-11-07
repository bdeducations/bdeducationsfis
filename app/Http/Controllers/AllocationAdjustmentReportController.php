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

class AllocationAdjustmentReportController extends Controller {

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
        $data['grand_total_allocation'] = 0;
        $data['grand_total_reception'] = 0;
        $data['grand_total_donation'] = 0;
        $data['grand_total_current_allocation'] = 0;
        $data['account_allocation_list'] = '';
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['total_allocation_by_area'] = '';
        $data['total_reception_by_area'] = '';
        $data['total_donation_by_area'] = '';
        $data['total_current_allocation_by_area'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
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
            $total_current_allocation_by_area = array();
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                    $total_current_allocation_by_area[$area_row->title] = $total_allocation_by_area[$area_row->title] + $total_reception_by_area[$area_row->title] - $total_donation_by_area[$area_row->title];
                } else {
                    /**
                     * Calculate grand total
                     */
                    $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                    $data['grand_total_reception'] = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $data['grand_total_donation'] = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $data['grand_total_current_allocation'] = $data['grand_total_allocation'] + $data['grand_total_reception'] - $data['grand_total_donation'];
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year);
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_current_allocation_by_area[$area->title] = $total_allocation_by_area[$area->title] + $total_reception_by_area[$area->title] - $total_donation_by_area[$area->title];
                    }
                }
            }
            $data['total_allocation_by_area'] = $total_allocation_by_area;
            $data['total_reception_by_area'] = $total_reception_by_area;
            $data['total_donation_by_area'] = $total_donation_by_area;
            $data['total_current_allocation_by_area'] = $total_current_allocation_by_area;
            $data['account_allocation_list'] = $common_model->allocationFilterHeadsWithAdjustment(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
        }
        return view($this->viewFolderPath . 'budget_allocation_adjustment_report', ['data' => $data]);
    }

    /**
     * Allocation Report With Adjustment PDF Download
     * @param Request $request
     */
    public function allocationReportPdfDownload(Request $request) {
        $data[] = '';
        $data['grand_total_allocation'] = 0;
        $data['grand_total_reception'] = 0;
        $data['grand_total_donation'] = 0;
        $data['grand_total_current_allocation'] = 0;
        $data['head_ancestor_hierarchy'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['total_allocation_by_area'] = '';
        $data['total_reception_by_area'] = '';
        $data['total_donation_by_area'] = '';
        $data['total_current_allocation_by_area'] = '';
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
            $total_current_allocation_by_area = array();
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                    $total_current_allocation_by_area[$area_row->title] = $total_allocation_by_area[$area_row->title] + $total_reception_by_area[$area_row->title] - $total_donation_by_area[$area_row->title];
                } else {
                    /**
                     * Calculate grand total
                     */
                    $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                    $data['grand_total_reception'] = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $data['grand_total_donation'] = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $data['grand_total_current_allocation'] = $data['grand_total_allocation'] + $data['grand_total_reception'] - $data['grand_total_donation'];
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year);
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_current_allocation_by_area[$area->title] = $total_allocation_by_area[$area->title] + $total_reception_by_area[$area->title] - $total_donation_by_area[$area->title];
                    }
                }
            }
            $data['total_allocation_by_area'] = $total_allocation_by_area;
            $data['total_reception_by_area'] = $total_reception_by_area;
            $data['total_donation_by_area'] = $total_donation_by_area;
            $data['total_current_allocation_by_area'] = $total_current_allocation_by_area;
            $data['account_allocation_list'] = $common_model->allocationFilterHeadsWithAdjustment(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
        }
        $pdf = PDF::loadView($this->viewFolderPath . 'budget_allocation_adjustment_report_pdf', ['data' => $data]);
        return $pdf->stream('budget_allocation_adjustment_report_pdf.pdf');
    }

    public function downloadAllocationReportCsv(Request $request) {
        $account_allocation_list = '';
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
            $total_allocation_by_area = array();
            $total_current_allocation_by_area = array();
            $total_reception_by_area = array();
            $total_donation_by_area = array();
            $grand_total_allocation = 0;
            $grand_total_reception = 0;
            $grand_total_donation = 0;
            $grand_total_current_allocation = 0;
            if ($head_row_id < 0) {
                if ($area_row_id > 0) {
                    $area_row = $common_model->get_area_row_info($area_row_id);
                    $total_allocation_by_area[$area_row->title] = $common_model->getTotalAllocation($area_row_id, $budget_year);
                    $total_reception_by_area[$area_row->title] = $common_model->getTotalReception($area_row_id, $budget_year, $from_date, $to_date);
                    $total_donation_by_area[$area_row->title] = $common_model->getTotalDonation($area_row_id, $budget_year, $from_date, $to_date);
                    $total_current_allocation_by_area[$area_row->title] = $total_allocation_by_area[$area_row->title] + $total_reception_by_area[$area_row->title] - $total_donation_by_area[$area_row->title];
                } else {
                    /**
                     * Calculate grand total
                     */
                    $grand_total_allocation = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
                    $grand_total_reception = $common_model->getTotalReception(-1, $budget_year, 0, 0);
                    $grand_total_donation = $common_model->getTotalDonation(-1, $budget_year, 0, 0);
                    $grand_total_current_allocation = $grand_total_allocation + $grand_total_reception - $grand_total_donation;
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_allocation_by_area[$area->title] = $common_model->getTotalAllocation($area->area_row_id, $budget_year);
                        $total_reception_by_area[$area->title] = $common_model->getTotalReception($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_donation_by_area[$area->title] = $common_model->getTotalDonation($area->area_row_id, $budget_year, $from_date, $to_date);
                        $total_current_allocation_by_area[$area->title] = $total_allocation_by_area[$area->title] + $total_reception_by_area[$area->title] - $total_donation_by_area[$area->title];
                    }
                }
            }
            $account_allocation_list = $common_model->allocationFilterHeadsWithAdjustment(1, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            if ($account_allocation_list) {
                $child_serial = 1;
                $parent_serial = 1;
                $grand_child_serial = 1;
                $grand_parent_child_number = 0;
                $grand_parent_child_counter = 0;
                $grand_parent_total_allocation = 0;
                $grand_parent_total_donation = 0;
                $grand_parent_head_total_adjustment = 0;
                $grand_parent_head_current_total_allocation = 0;
                $parent_child_number = 0;
                $parent_child_counter = 0;
                $parent_total_allocation = 0;
                $parent_head_total_donation = 0;
                $parent_head_total_adjustment = 0;
                $parent_head_current_total_allocation = 0;
                foreach ($account_allocation_list as $area_row_id_key => $area_allocation_row) {
                    if (isset($child_serial) && $child_serial > 26):
                        $child_serial = 1;
                    endif;
                    if (isset($grand_child_serial) && $grand_child_serial > 26):
                        $grand_child_serial = 1;
                    endif;
                    foreach ($area_allocation_row as $allocation_row) {
                        $a = array();
                        if ($allocation_row['level'] == 0) {
                            $child_serial = 1;
                            $head_serial_number = $parent_serial . ". ";
                            $parent_serial++;
                            $grand_parent_child_counter = 0;
                            if ($allocation_row['has_child'] == 1) {
                                $parent_child_number = $allocation_row['parent_head_child_number'];
                                $parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                $grand_parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                $grand_parent_total_donation = $allocation_row['parent_head_total_donation'];
                                $parent_head_total_donation = $allocation_row['parent_head_total_donation'];
                                $grand_parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                $parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                $grand_parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
                                $parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
                                $grand_parent_child_number = $allocation_row['parent_head_child_number'];
                                $parent_child_counter = 0;
                            }
                        }
                        if ($allocation_row['level'] == 1) {
                            $grand_child_serial = 1;
                            $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                            $child_serial++;
                            if ($allocation_row['has_child'] == 1):
                                $parent_child_number = $allocation_row['parent_head_child_number'];
                                $parent_child_counter = 0;
                                $parent_total_allocation = $allocation_row['parent_head_total_allocation'];
                                $parent_head_total_donation = $allocation_row['parent_head_total_donation'];
                                $parent_head_total_adjustment = $allocation_row['parent_head_total_adjustment'];
                                $parent_head_current_total_allocation = $allocation_row['parent_head_current_total_allocation'];
                                $grand_parent_child_counter++;
                            else:
                                $parent_child_counter++;
                            endif;
                        }
                        if ($allocation_row['level'] == 2) {
                            $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                            $grand_child_serial++;
                            $parent_child_counter++;
                        }
                        $a['Head Name'] = $head_serial_number . $allocation_row['title'];
                        $a['Area Name'] = $area_row_id_key;
                        if (isset($allocation_row['head_total_allocation']) && !empty($allocation_row['head_total_allocation']) && ($allocation_row['has_child'] == 0)) {
                            $a['Allocation(original)'] = number_format($allocation_row['head_total_allocation'], 2);
                        } else {
                            $a['Allocation(original)'] = 0.00;
                        }
                        if (isset($allocation_row['head_total_donation']) && !empty($allocation_row['head_total_donation']) && ($allocation_row['has_child'] == 0)) {
                            $a['Donate)'] = number_format($allocation_row['head_total_donation'], 2);
                        } else {
                            $a['Donate'] = 0.00;
                        }
                        if (isset($allocation_row['head_total_adjustment']) && !empty($allocation_row['head_total_adjustment']) && ($allocation_row['has_child'] == 0)) {
                            $a['Receive)'] = number_format($allocation_row['head_total_adjustment'], 2);
                        } else {
                            $a['Receive'] = 0.00;
                        }
                        if (isset($allocation_row['head_current_total_allocation']) && !empty($allocation_row['head_current_total_allocation']) && ($allocation_row['has_child'] == 0)) {
                            $a['Allocation(Current))'] = number_format($allocation_row['head_current_total_allocation'], 2);
                        } else {
                            $a['Allocation(Current)'] = 0.00;
                        }
                        $data[] = (array) $a;
                        if (($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 1) && ($allocation_row['has_child'] == 0)):
                            $parent_total['Head Name'] = "Total";
                            $parent_total['Area Name'] = '';
                            $parent_total['Allocation(original)'] = number_format($parent_total_allocation, 2);
                            $parent_total['Donate'] = number_format($parent_head_total_donation, 2);
                            $parent_total['Receive'] = number_format($parent_head_total_adjustment, 2);
                            $parent_total['Allocation(Current)'] = number_format($parent_head_current_total_allocation, 2);
                            $data[] = (array) $parent_total;
                        endif;
                        if (($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)):
                            $parent_child_total['Head Name'] = "    Total";
                            $parent_child_total['Area Name'] = '';
                            $parent_child_total['Allocation(original)'] = number_format($parent_total_allocation, 2);
                            $parent_child_total['Donate'] = number_format($parent_head_total_donation, 2);
                            $parent_child_total['Receive'] = number_format($parent_head_total_adjustment, 2);
                            $parent_child_total['Allocation(Current)'] = number_format($parent_head_current_total_allocation, 2);
                            $data[] = (array) $parent_child_total;
                        endif;
                        if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($allocation_row['level'] == 2) && ($allocation_row['has_child'] == 0)):
                            $grand_parent_total['Head Name'] = "Total";
                            $grand_parent_total['Area Name'] = '';
                            $grand_parent_total['Allocation(original)'] = number_format($grand_parent_total_allocation, 2);
                            $grand_parent_total['Donate'] = number_format($grand_parent_total_donation, 2);
                            $grand_parent_total['Receive'] = number_format($grand_parent_head_total_adjustment, 2);
                            $grand_parent_total['Allocation(Current)'] = number_format($grand_parent_head_current_total_allocation, 2);
                            $data[] = (array) $grand_parent_total;
                        endif;
                    }
                    if ($head_row_id == -1):
                        $area_total['Head Name'] = "Total( " . $area_row_id_key . " )";
                        $area_total['Area Name'] = $area_row_id_key;
                        $area_total['Allocation(original)'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                        $area_total['Donate'] = number_format($total_donation_by_area[$area_row_id_key], 2);
                        $area_total['Receive'] = number_format($total_reception_by_area[$area_row_id_key], 2);
                        $area_total['Allocation(Current)'] = number_format($total_current_allocation_by_area[$area_row_id_key], 2);
                        $data[] = (array) $area_total;
                    endif;
                    $parent_serial = 1;
                }
                if (($head_row_id == -1) && ($area_row_id == -1)):
                    $all_area_total['Head Name'] = "Grand Total( All Areas )";
                    $all_area_total['Area Name'] = "All Areas";
                    $all_area_total['Allocation(original)'] = number_format($grand_total_allocation, 2);
                    $all_area_total['Donate'] = number_format($grand_total_donation, 2);
                    $all_area_total['Receive'] = number_format($grand_total_reception, 2);
                    $all_area_total['Allocation(Current)'] = number_format($grand_total_current_allocation, 2);
                    $data[] = (array) $all_area_total;
                endif;
            }
            if ($area_row_id > 0):
                $area_row = $common_model->get_area_row_info($area_row_id);
                $area_name = str_replace(" ", "_", $area_row->title) . "_" . $budget_year;
            else:
                $area_name = "All_Area_" . $budget_year;
            endif;
            $data['allocation_list'] = $data;
           /* echo "<pre>";
            print_r($data['allocation_list']);
            die;
            echo "</pre>";*/
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
