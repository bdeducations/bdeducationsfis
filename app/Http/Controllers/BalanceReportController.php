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

class BalanceReportController extends Controller {

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
     * Show the head Expense List.
     *
     * @return head expense list object
     */
    public function index(Request $request) {
        $data[] = '';
        $expenseFilterHead = '';
        $data['area_name'] = '';
        $data['account_expense_list'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['selected_date_type'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['from_month'] = '';
        $data['to_month'] = '';
        $data['total_month'] = '';
        $data['area_total_allocation'] = 0;
        $data['area_total_expense'] = 0;
        $data['area_total_balance'] = 0;
        $total_expense = 0;
        $total_allocation_by_area = array();
        $total_area_expense_by_month = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $all_area_list = $common_model->allAreaList(1);
        $data['all_area_list'] = $all_area_list;
        $data['all_areas'] = $common_model->allAreas(1);
        $data['month_list'] = $common_model->month_array;
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        if ($request->isMethod('POST') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $date_type = $request->date_type;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $data['selected_date_type'] = $request->date_type;
            if ($date_type == 1) {
                $from_month = isset($request->from_month) ? $request->from_month : (int) date('m');
                $to_month = isset($request->to_month) ? $request->to_month : (int) date('m');
                $total_month = $to_month - $from_month + 1;
                $data['total_month'] = $total_month;
                $data['from_month'] = $from_month;
                $data['to_month'] = $to_month;
                $balance_report_by_month = $common_model->balanceReportByMonthRange(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
                $data['balance_report_by_month_list'] = $balance_report_by_month;
                //dd($balance_report_by_month);
                if ($head_row_id < 0) {
                    if ($area_row_id > 0) {
                        /** All Head for specific Area */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $total_allocation_by_area[$area_row_detail->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $start_month = $from_month;
                        for ($start_month; $start_month <= $total_month; $start_month++) {
                            $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row_id, $budget_year, $start_month);
                            $total_expense += $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month];
                        }
                        $data['total_allocation_by_area'] = $total_allocation_by_area;
                        $data['total_area_expense_by_month'] = $total_area_expense_by_month;
                        $data['total_expense_by_area'][$area_row_detail->area_row_id] = $total_expense;
                        $data['total_balance_by_area'][$area_row_detail->area_row_id] = $total_allocation_by_area[$area_row_detail->area_row_id] - $total_expense;
                    } else {
                        /** All Head for All Area */
                        $data['grand_total_allocation_all_area'] = 0;
                        $data['grand_total_expense_all_area'] = 0;
                        $data['grand_total_balance_all_area'] = 0;
                        for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                            $data['grand_total_expense_by_month_all_area'][$start_month] = $common_model->getTotalAreaExpenseByMonth(-1, $budget_year, $start_month);
                        }
                        foreach ($data['all_areas'] as $area_row) {
                            $total_area_expense = 0;
                            $data['total_allocation_by_area'][$area_row->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row->area_row_id, $budget_year, 0, 0);
                            $data['grand_total_allocation_all_area'] += $data['total_allocation_by_area'][$area_row->area_row_id];
                            for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                                $data['total_area_expense_by_month'][$area_row->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row->area_row_id, $budget_year, $start_month);
                                $total_area_expense += $data['total_area_expense_by_month'][$area_row->area_row_id][$start_month];
                            }
                            $data['total_expense_by_area'][$area_row->area_row_id] = $total_area_expense;
                            $data['total_balance_by_area'][$area_row->area_row_id] = $data['total_allocation_by_area'][$area_row->area_row_id] - $total_area_expense;
                            $data['grand_total_expense_all_area'] += $data['total_expense_by_area'][$area_row->area_row_id];
                            $data['grand_total_balance_all_area'] += $data['total_balance_by_area'][$area_row->area_row_id];
                        }
                        //dd($data['total_area_expense_by_month']);
                    }
                }
                return view($this->viewFolderPath . 'budget_balance_report_by_month', ['data' => $data]);
            } else {
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
                if ($head_row_id > 0) {
                    /*
                     * Call For a specific head
                     */
                    if ($area_row_id > 0) {
                        /* For specific area and specific head */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $data['area_name'] = $area_row_detail->title;
                        $expenseFilterHead = $common_model->expenseFilterHeads(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_report', ['data' => $data]);
                    } else {
                        /* For All Area and specific head */
                        $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, true, $head_row_id, $budget_year, $from_date, $to_date);
                        //dd($expenseFilterHead);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_report_all_area_single_head', ['data' => $data]);
                    }
                } else {
                    /*
                     * Call For all head
                     */
                    if ($area_row_id > 0) {
                        /*
                         * Call For all head for a specific area
                         */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $data['area_total_allocation'] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $data['area_total_expense'] = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, $from_date, $to_date);
                        $data['area_total_balance'] = $data['area_total_allocation'] - $data['area_total_expense'];
                        $data['area_name'] = $area_row_detail->title;
                        $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, true, $area_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_report', ['data' => $data]);
                    } else {
                        /*
                         * Call For all head for all area
                         */
                        $area_list = $common_model->allAreas(1);
                        foreach ($area_list as $area) {
                            $total_allocation_by_area[$area->title] = $common_model->getTotalAllocationWithAdjustmentByArea($area->area_row_id, $budget_year, 0, 0);
                            $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                            $total_balance_by_area[$area->title] = $total_allocation_by_area[$area->title] - $total_expense_by_area[$area->title];
                        }
                        $data['total_allocation_by_area'] = $total_allocation_by_area;
                        $data['grand_total_allocation'] = $common_model->getTotalAllocationWithAdjustmentByArea(-1, $budget_year, 0, 0);
                        $data['total_expense_by_area'] = $total_expense_by_area;
                        $data['grand_total_expense'] = $common_model->getTotalExpenseByArea(-1, $budget_year, $from_date, $to_date);
                        $data['grand_total_balance'] = $data['grand_total_allocation'] - $data['grand_total_expense'];
                        $data['total_balance_by_area'] = $total_balance_by_area;
                        $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, true, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        //dd($expenseFilterHead);
                        return view($this->viewFolderPath . 'budget_balance_report_all_area_single_head', ['data' => $data]);
                    }
                }
            }
        } else {
            return view($this->viewFolderPath . 'budget_balance_report', ['data' => $data]);
        }
    }

    /**
     * Expense Report PDF Download
     * @param Request $request
     */
    public function balanceReportPdfDownload(Request $request) {
        $data[] = '';
        $expenseFilterHead = '';
        $total_allocation_by_area = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $data['area_name'] = '';
        $data['account_expense_list'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['selected_date_type'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['from_month'] = '';
        $data['to_month'] = '';
        $data['total_month'] = '';
        $data['area_total_allocation'] = 0;
        $data['area_total_expense'] = 0;
        $data['area_total_balance'] = 0;
        $total_expense = 0;
        $total_allocation_by_area = array();
        $total_area_expense_by_month = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $all_area_list = $common_model->allAreaList(1);
        $data['all_area_list'] = $all_area_list;
        $data['all_areas'] = $common_model->allAreas(1);
        $data['month_list'] = $common_model->month_array;
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
            $date_type = $request->date_type;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['selected_budget_year'] = $request->budget_year;
            $data['selected_date_type'] = $request->date_type;
            $area_row_detail = $common_model->get_area_row_info($area_row_id);
            $data['area_row_detail'] = $area_row_detail;
            if ($date_type == 1) {
                $from_month = $request->from_month;
                $to_month = $request->to_month;
                $total_month = $to_month - $from_month + 1;
                $data['total_month'] = $total_month;
                $data['from_month'] = $from_month;
                $data['to_month'] = $to_month;
                $balance_report_by_month = $common_model->balanceReportByMonthRange(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
                //dd($balance_report_by_month);
                $data['balance_report_by_month_list'] = $balance_report_by_month;
                if ($head_row_id < 0) {
                    if ($area_row_id > 0) {
                        /** All Head for specific Area */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $total_allocation_by_area[$area_row_detail->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $start_month = $from_month;
                        for ($start_month; $start_month <= $total_month; $start_month++) {
                            $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row_id, $budget_year, $start_month);
                            $total_expense += $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month];
                        }
                        $data['total_allocation_by_area'] = $total_allocation_by_area;
                        $data['total_area_expense_by_month'] = $total_area_expense_by_month;
                        $data['total_expense_by_area'][$area_row_detail->area_row_id] = $total_expense;
                        $data['total_balance_by_area'][$area_row_detail->area_row_id] = $total_allocation_by_area[$area_row_detail->area_row_id] - $total_expense;
                    } else {
                        /** All Head for All Area */
                        $data['grand_total_allocation_all_area'] = 0;
                        $data['grand_total_expense_all_area'] = 0;
                        $data['grand_total_balance_all_area'] = 0;
                        for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                            $data['grand_total_expense_by_month_all_area'][$start_month] = $common_model->getTotalAreaExpenseByMonth(-1, $budget_year, $start_month);
                        }
                        foreach ($data['all_areas'] as $area_row) {
                            $total_area_expense = 0;
                            $data['total_allocation_by_area'][$area_row->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row->area_row_id, $budget_year, 0, 0);
                            $data['grand_total_allocation_all_area'] += $data['total_allocation_by_area'][$area_row->area_row_id];
                            for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                                $data['total_area_expense_by_month'][$area_row->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row->area_row_id, $budget_year, $start_month);
                                $total_area_expense += $data['total_area_expense_by_month'][$area_row->area_row_id][$start_month];
                            }
                            $data['total_expense_by_area'][$area_row->area_row_id] = $total_area_expense;
                            $data['total_balance_by_area'][$area_row->area_row_id] = $data['total_allocation_by_area'][$area_row->area_row_id] - $total_area_expense;
                            $data['grand_total_expense_all_area'] += $data['total_expense_by_area'][$area_row->area_row_id];
                            $data['grand_total_balance_all_area'] += $data['total_balance_by_area'][$area_row->area_row_id];
                        }
                        //dd($data['total_area_expense_by_month']);
                    }
                }
                $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_report_by_month_pdf', ['data' => $data]);
                $pdf->setPaper('legal', 'landscape');
                return $pdf->stream('budget_balance_report_by_month_pdf.pdf');
                //return view($this->viewFolderPath . 'budget_balance_report_by_month_pdf', ['data' => $data]);
            } else {
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
                if ($head_row_id > 0) {
                    /*
                     * Call For a specific head
                     */
                    if ($area_row_id > 0) {
                        /* For specific area and specific head */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $data['area_name'] = $area_row_detail->title;
                        $expenseFilterHead = $common_model->expenseFilterHeads(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_report_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_report_pdf.pdf');
                    } else {
                        /* For All Area and specific head */
                        $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, true, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_report_all_area_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_report_all_area_pdf.pdf');
                    }
                } else {
                    /*
                     * Call For all head
                     */
                    if ($area_row_id > 0) {
                        /*
                         * Call For all head for a specific area
                         */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $data['area_name'] = $area_row_detail->title;
                        $data['area_total_allocation'] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $data['area_total_expense'] = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, 0, 0, $from_date, $to_date);
                        $data['area_total_balance'] = $data['area_total_allocation'] - $data['area_total_expense'];
                        $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, true, $area_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_report_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_report_pdf.pdf');
                    } else {
                        /*
                         * Call For all head for all area
                         */
                        $area_list = $common_model->allAreas(1);
                        foreach ($area_list as $area) {
                            $total_allocation_by_area[$area->title] = $common_model->getTotalAllocationWithAdjustmentByArea($area->area_row_id, $budget_year, 0, 0);
                            $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                            $total_balance_by_area[$area->title] = $total_allocation_by_area[$area->title] - $total_expense_by_area[$area->title];
                        }
                        $data['total_allocation_by_area'] = $total_allocation_by_area;
                        $data['grand_total_allocation'] = $common_model->getTotalAllocationWithAdjustmentByArea(-1, $budget_year, 0, 0);
                        $data['total_expense_by_area'] = $total_expense_by_area;
                        $data['grand_total_expense'] = $common_model->getTotalExpenseByArea(-1, $budget_year, $from_date, $to_date);
                        $data['grand_total_balance'] = $data['grand_total_allocation'] - $data['grand_total_expense'];
                        $data['total_balance_by_area'] = $total_balance_by_area;
                        $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, true, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        //dd($expenseFilterHead);
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_report_all_area_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_report_all_area_pdf.pdf');
                    }
                }
            }
        }
    }

    public function balanceReportCSVDownload(Request $request) {
        $expenseFilterHead = '';
        $total_allocation_by_area = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $total_expense = 0;
        $grand_total_expense_by_month_all_area = array();
        $total_area_expense_by_month = array();
        $common_model = new Common();
        $all_areas = $common_model->allAreas(1);
        $all_area_list = $common_model->allAreaList(1);
        $month_list = $common_model->month_array;
        $alphabets = $common_model->alphabet_array;
        $roman = $common_model->roman_array;
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $date_type = $request->date_type;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            if ($date_type == 1) {
                $from_month = $request->from_month;
                $to_month = $request->to_month;
                $total_month = $to_month - $from_month + 1;
                $balance_report_by_month = $common_model->balanceReportByMonthRange(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
                if ($head_row_id < 0) {
                    if ($area_row_id > 0) {
                        /** All Head for specific Area */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $total_allocation_by_area[$area_row_detail->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $start_month = $from_month;
                        $end_month = $to_month;
                        for ($start_month; $start_month <= $total_month; $start_month++) {
                            $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row_id, $budget_year, $start_month);
                            $total_expense += $total_area_expense_by_month[$area_row_detail->area_row_id][$start_month];
                        }
                        $total_expense_by_area[$area_row_detail->area_row_id] = $total_expense;
                        $total_balance_by_area[$area_row_detail->area_row_id] = $total_allocation_by_area[$area_row_detail->area_row_id] - $total_expense;
                    } else {
                        /** All Head for All Area */
                        $grand_total_allocation_all_area = 0;
                        $grand_total_expense_all_area = 0;
                        $grand_total_balance_all_area = 0;
                        for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                            $grand_total_expense_by_month_all_area[$start_month] = $common_model->getTotalAreaExpenseByMonth(-1, $budget_year, $start_month);
                        }
                        foreach ($all_areas as $area_row) {
                            $total_area_expense = 0;
                            $total_allocation_by_area[$area_row->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row->area_row_id, $budget_year, 0, 0);
                            $grand_total_allocation_all_area += $total_allocation_by_area[$area_row->area_row_id];
                            for ($start_month = $from_month; $start_month <= $total_month; ++$start_month) {
                                $total_area_expense_by_month[$area_row->area_row_id][$start_month] = $common_model->getTotalAreaExpenseByMonth($area_row->area_row_id, $budget_year, $start_month);
                                $total_area_expense += $total_area_expense_by_month[$area_row->area_row_id][$start_month];
                            }
                            $total_expense_by_area[$area_row->area_row_id] = $total_area_expense;
                            $total_balance_by_area[$area_row->area_row_id] = $total_allocation_by_area[$area_row->area_row_id] - $total_area_expense;
                            $grand_total_expense_all_area += $total_expense_by_area[$area_row->area_row_id];
                            $grand_total_balance_all_area += $total_balance_by_area[$area_row->area_row_id];
                        }
                    }
                }
                if ($balance_report_by_month) {
                    $parent_head_total_expense_by_month = array();
                    $grand_parent_head_total_expense_by_month = array();
                    $child_serial = 1;
                    $parent_serial = 1;
                    $grand_child_serial = 1;
                    $grand_parent_child_number = 0;
                    $grand_parent_child_counter = 0;
                    $grand_parent_total_allocation = 0;
                    $grand_parent_total_expense = 0;
                    $grand_parent_total_balance = 0;
                    $parent_child_number = 0;
                    $parent_child_counter = 0;
                    $parent_total_allocation = 0;
                    $parent_total_expense = 0;
                    $parent_total_balance = 0;
                    foreach ($balance_report_by_month as $area_row_id_key => $mothly_balance_row) {
                        if (isset($child_serial) && $child_serial > 26):
                            $child_serial = 1;
                        endif;
                        if (isset($grand_child_serial) && $grand_child_serial > 26):
                            $grand_child_serial = 1;
                        endif;
                        foreach ($mothly_balance_row as $head_row_id_key => $area_balance_row) {
                            $a = array();
                            if ($area_balance_row['level'] == 0):
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                $head_serial_number = $parent_serial . ". ";
                                if ($area_balance_row['has_child'] == 1):
                                    $parent_child_number = $area_balance_row['parent_head_child_number'];
                                    $parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                    $parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                    $parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                    $grand_parent_child_number = $area_balance_row['parent_head_child_number'];
                                    $grand_parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                    $grand_parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                    $grand_parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                    $parent_child_counter = 0;
                                    foreach ($area_balance_row[0] as $month_key => $monthly_expense_row):
                                        $parent_head_total_expense_by_month[$month_key] = $monthly_expense_row;
                                    endforeach;
                                    $grand_parent_head_total_expense_by_month = $parent_head_total_expense_by_month;
                                endif;
                                $parent_serial++;
                            endif;
                            if ($area_balance_row['level'] == 1):
                                $grand_child_serial = 1;
                                $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                $child_serial++;
                                if ($area_balance_row['has_child'] == 1):
                                    $parent_child_number = $area_balance_row['parent_head_child_number'];
                                    $parent_total_allocation = $area_balance_row['parent_head_total_allocation'];
                                    $parent_total_expense = $area_balance_row['parent_head_total_expense'];
                                    $parent_total_balance = $area_balance_row['parent_head_current_balance'];
                                    $parent_child_counter = 0;
                                    $grand_parent_child_counter++;
                                    foreach ($area_balance_row[0] as $month_key => $monthly_expense_row):
                                        $parent_head_total_expense_by_month[$month_key] = $monthly_expense_row;
                                    endforeach;
                                else:
                                    $parent_child_counter++;
                                endif;
                            endif;
                            if ($area_balance_row['level'] == 2):
                                $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                $grand_child_serial++;
                                $parent_child_counter++;
                            endif;
                            $a['Head Name'] = $head_serial_number . $area_balance_row['title'];
                            $a['Area Name'] = $all_area_list[$area_row_id_key];
                            if (isset($area_balance_row['head_total_allocation']) && !empty($area_balance_row['head_total_allocation']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Allocation'] = number_format($area_balance_row['head_total_allocation'], 2);
                            } elseif (isset($area_balance_row['head_total_allocation']) && empty($area_balance_row['head_total_allocation']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Allocation'] = number_format(0.00, 2);
                            } else {
                                $a['Allocation'] = '';
                            }
                            if ($area_balance_row['has_child'] == 1):
                                for ($start_month = $from_month; $start_month <= $to_month; $start_month++):
                                    $a[$month_list[$start_month]] = '';
                                endfor;
                            else:
                                foreach ($area_balance_row[0] as $month_key => $monthly_expense_row):
                                    $a[$month_list[$month_key]] = number_format($monthly_expense_row, 2);
                                endforeach;
                            endif;
                            if (isset($area_balance_row['head_total_expense']) && !empty($area_balance_row['head_total_expense']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Total Expense'] = number_format($area_balance_row['head_total_expense'], 2);
                            } elseif (isset($area_balance_row['head_total_expense']) && empty($area_balance_row['head_total_expense']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Total Expense'] = number_format(0.00, 2);
                            } else {
                                $a['Total Expense'] = '';
                            }
                            if (isset($area_balance_row['head_current_balance']) && !empty($area_balance_row['head_current_balance']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Balance'] = number_format($area_balance_row['head_current_balance'], 2);
                            } elseif (isset($area_balance_row['head_current_balance']) && empty($area_balance_row['head_current_balance']) && ($area_balance_row['has_child'] == 0)) {
                                $a['Balance'] = number_format(0.00, 2);
                            } else {
                                $a['Balance'] = '';
                            }
                            $data[] = (array) $a;
                            if (($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 1) && ($area_balance_row['has_child'] == 0)):
                                $parent_total['Head Name'] = "Total";
                                $parent_total['Area Name'] = '';
                                $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                foreach ($parent_head_total_expense_by_month as $month_key => $monthly_expense_row):
                                    $parent_total[$month_list[$month_key]] = number_format($monthly_expense_row, 2);
                                endforeach;
                                $parent_total['Total Expense'] = number_format($parent_total_expense, 2);
                                $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 2) && ($area_balance_row['has_child'] == 0)):
                                $parent_total['Head Name'] = "    Total";
                                $parent_total['Area Name'] = '';
                                $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                foreach ($parent_head_total_expense_by_month as $month_key => $monthly_expense_row):
                                    $parent_total[$month_list[$month_key]] = number_format($monthly_expense_row, 2);
                                endforeach;
                                $parent_total['Total Expense'] = number_format($parent_total_expense, 2);
                                $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_balance_row['level'] == 2) && ($area_balance_row['has_child'] == 0)):
                                $grand_parent_total['Head Name'] = "Total";
                                $grand_parent_total['Area Name'] = '';
                                $grand_parent_total['Allocation'] = number_format($grand_parent_total_allocation, 2);
                                foreach ($grand_parent_head_total_expense_by_month as $month_key => $monthly_expense_row):
                                    $grand_parent_total[$month_list[$month_key]] = number_format($monthly_expense_row, 2);
                                endforeach;
                                $grand_parent_total['Total Expense'] = number_format($grand_parent_total_expense, 2);
                                $grand_parent_total['Balance'] = number_format($grand_parent_total_balance, 2);
                                $data[] = (array) $grand_parent_total;
                            endif;
                        }
                        if (($head_row_id == -1)):
                            $area_total['Head Name'] = "Total( " . $all_area_list[$area_row_id_key] . " )";
                            $area_total['Area Name'] = '';
                            $area_total['Allocation'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                            for ($start_month = $from_month; $start_month <= $to_month; $start_month++):
                                $area_total[$month_list[$month_key]] = number_format($total_area_expense_by_month[$area_row_id_key][$start_month], 2);
                            endfor;
                            $area_total['Total Expense'] = number_format($total_expense_by_area[$area_row_id_key], 2);
                            $area_total['Balance'] = number_format($total_balance_by_area[$area_row_id_key], 2);
                            $data[] = (array) $area_total;
                        endif;
                        $parent_serial = 1;
                    }
                    if (($head_row_id == -1) && ($area_row_id == -1)):
                        $all_area_total['Head Name'] = "Grand Total( All Areas )";
                        $all_area_total['Area Name'] = '';
                        $all_area_total['Allocation'] = number_format($grand_total_allocation_all_area, 2);
                        for ($start_month = $from_month; $start_month <= $to_month; $start_month++):
                            $all_area_total[$month_list[$month_key]] = number_format($grand_total_expense_by_month_all_area[$start_month], 2);
                        endfor;
                        $all_area_total['Total Expense'] = number_format($grand_total_expense_all_area, 2);
                        $all_area_total['Balance'] = number_format($grand_total_balance_all_area, 2);
                        $data[] = (array) $all_area_total;
                    endif;
                    if ($area_row_id > 0) {
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $area_name = str_replace(" ", "_", $area_row_detail->title) . "_" . $budget_year;
                    } else {
                        $area_name = "All_Area_" . $budget_year;
                    }
                }
            } else {
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
                if ($head_row_id > 0) {
                    /*
                     * Call For a specific head
                     */
                    if ($area_row_id > 0) {
                        /* For specific area and specific head */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $area_name = str_replace(" ", "_", $area_row_detail->title) . "_" . $budget_year;
                        $expenseFilterHead = $common_model->expenseFilterHeads(true, true, true, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        if ($expenseFilterHead) {
                            $child_serial = 1;
                            $parent_serial = 1;
                            $grand_child_serial = 1;
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_allocation = 0;
                            $grand_parent_total_expense = 0;
                            $grand_parent_total_balance = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_allocation = 0;
                            $parent_total_expense = 0;
                            $parent_total_balance = 0;
                            foreach ($expenseFilterHead as $expense_row) {
                                $a = array();
                                if (isset($child_serial) && $child_serial > 26):
                                    $child_serial = 1;
                                endif;
                                if (isset($grand_child_serial) && $grand_child_serial > 26):
                                    $grand_child_serial = 1;
                                endif;
                                if ($expense_row->level == 0):
                                    $grand_parent_child_counter = 0;
                                    $child_serial = 1;
                                    $head_serial_number = $parent_serial . ". ";
                                    if ($expense_row->has_child == 1):
                                        $parent_child_number = $expense_row->parent_head_child_number;
                                        $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $parent_total_expense = $expense_row->parent_head_total_expense;
                                        $parent_total_balance = $expense_row->parent_head_current_balance;
                                        $grand_parent_child_number = $expense_row->parent_head_child_number;
                                        $grand_parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $grand_parent_total_expense = $expense_row->parent_head_total_expense;
                                        $grand_parent_total_balance = $expense_row->parent_head_current_balance;
                                        $parent_child_counter = 0;
                                    endif;
                                    $parent_serial++;
                                endif;
                                if ($expense_row->level == 1):
                                    $grand_child_serial = 1;
                                    $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                    $child_serial++;
                                    if ($expense_row->has_child == 1):
                                        $parent_child_number = $expense_row->parent_head_child_number;
                                        $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $parent_total_expense = $expense_row->parent_head_total_expense;
                                        $parent_total_balance = $expense_row->parent_head_current_balance;
                                        $parent_child_counter = 0;
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                    endif;
                                endif;
                                if ($expense_row->level == 2):
                                    $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                endif;
                                $a['Head Name'] = $head_serial_number . $expense_row->title;
                                if (isset($expense_row->total_allocation) && !empty($expense_row->total_allocation) && ($expense_row->has_child == 0)) {
                                    $a['Allocation'] = number_format($expense_row->total_allocation, 2);
                                } elseif (isset($expense_row->total_allocation) && empty($expense_row->total_allocation) && ($expense_row->has_child == 0)) {
                                    $a['Allocation'] = number_format(0.00, 2);
                                } else {
                                    $a['Allocation'] = '';
                                }
                                if (isset($expense_row->total_expense) && !empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                    $a['Expense'] = number_format($expense_row->total_expense, 2);
                                } elseif (isset($expense_row->total_expense) && empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                    $a['Expense'] = number_format(0.00, 2);
                                } else {
                                    $a['Expense'] = '';
                                }
                                if (isset($expense_row->head_current_balance) && !empty($expense_row->head_current_balance) && ($expense_row->has_child == 0)) {
                                    $a['Balance'] = number_format($expense_row->head_current_balance, 2);
                                } elseif (isset($expense_row->head_current_balance) && empty($expense_row->head_current_balance) && ($expense_row->has_child == 0)) {
                                    $a['Balance'] = number_format(0.00, 2);
                                } else {
                                    $a['Balance'] = '';
                                }
                                $data[] = (array) $a;
                                if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)):
                                    $parent_total['Head Name'] = "Total";
                                    $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                    $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                    $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                    $parent_total['Head Name'] = "    Total";
                                    $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                    $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                    $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                    $grand_parent_total['Head Name'] = "Total";
                                    $grand_parent_total['Allocation'] = number_format($grand_parent_total_allocation, 2);
                                    $grand_parent_total['Expense'] = number_format($grand_parent_total_expense, 2);
                                    $grand_parent_total['Balance'] = number_format($grand_parent_total_balance, 2);
                                    $data[] = (array) $grand_parent_total;
                                endif;
                            }
                        }
                    } else {
                        /* For All Area and specific head */
                        $area_name = "All_Area_" . $budget_year;
                        $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, true, $head_row_id, $budget_year, $from_date, $to_date);
                        if ($expenseFilterHead) {
                            $child_serial = 1;
                            $parent_serial = 1;
                            $grand_child_serial = 1;
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_allocation = 0;
                            $grand_parent_total_expense = 0;
                            $grand_parent_total_balance = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_allocation = 0;
                            $parent_total_expense = 0;
                            $parent_total_balance = 0;
                            foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                                if (isset($child_serial) && $child_serial > 26):
                                    $child_serial = 1;
                                endif;
                                if (isset($grand_child_serial) && $grand_child_serial > 26):
                                    $grand_child_serial = 1;
                                endif;
                                foreach ($expense_row as $area_expense_row) {
                                    $a = array();
                                    if ($area_expense_row['level'] == 0):
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        $head_serial_number = $parent_serial . ". ";
                                        if ($area_expense_row['has_child'] == 1):
                                            $parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $grand_parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $grand_parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $parent_child_counter = 0;
                                        endif;
                                        $parent_serial++;
                                    endif;
                                    if ($area_expense_row['level'] == 1):
                                        $grand_child_serial = 1;
                                        $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                        $child_serial++;
                                        if ($area_expense_row['has_child'] == 1):
                                            $parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $parent_child_counter = 0;
                                            $grand_parent_child_counter++;
                                        else:
                                            $parent_child_counter++;
                                        endif;
                                    endif;
                                    if ($area_expense_row['level'] == 2):
                                        $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                        $grand_child_serial++;
                                        $parent_child_counter++;
                                    endif;
                                    $a['Head Name'] = $head_serial_number . $area_expense_row['title'];
                                    $a['Area Name'] = $area_row_id_key;
                                    if (isset($area_expense_row['total_allocation']) && !empty($area_expense_row['total_allocation']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Allocation'] = number_format($area_expense_row['total_allocation'], 2);
                                    } elseif (isset($area_expense_row['total_allocation']) && empty($area_expense_row['total_allocation']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Allocation'] = number_format(0.00, 2);
                                    } else {
                                        $a['Allocation'] = '';
                                    }
                                    if (isset($area_expense_row['total_expense']) && !empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Expense'] = number_format($area_expense_row['total_expense'], 2);
                                    } elseif (isset($area_expense_row['total_expense']) && empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Expense'] = number_format(0.00, 2);
                                    } else {
                                        $a['Expense'] = '';
                                    }
                                    if (isset($area_expense_row['head_current_balance']) && !empty($area_expense_row['head_current_balance']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Balance'] = number_format($area_expense_row['head_current_balance'], 2);
                                    } elseif (isset($area_expense_row['head_current_balance']) && empty($area_expense_row['head_current_balance']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Balance'] = number_format(0.00, 2);
                                    } else {
                                        $a['Balance'] = '';
                                    }
                                    $data[] = (array) $a;
                                    if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)):
                                        $parent_total['Head Name'] = "Total";
                                        $parent_total['Area Name'] = '';
                                        $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                        $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                        $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                        $data[] = (array) $parent_total;
                                    endif;
                                    if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                        $parent_total['Head Name'] = "    Total";
                                        $parent_total['Area Name'] = '';
                                        $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                        $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                        $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                        $data[] = (array) $parent_total;
                                    endif;
                                    if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                        $grand_parent_total['Head Name'] = "Total";
                                        $grand_parent_total['Area Name'] = '';
                                        $grand_parent_total['Allocation'] = number_format($grand_parent_total_allocation, 2);
                                        $grand_parent_total['Expense'] = number_format($grand_parent_total_expense, 2);
                                        $grand_parent_total['Balance'] = number_format($grand_parent_total_balance, 2);
                                        $data[] = (array) $grand_parent_total;
                                    endif;
                                }
                                $parent_serial = 1;
                            }
                        }
                    }
                } else {
                    /*
                     * Call For all head For specific area
                     */
                    if ($area_row_id > 0) {
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $area_name = str_replace(" ", "_", $area_row_detail->title) . "_" . $budget_year;
                        $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, true, $area_row_id, $budget_year, $from_date, $to_date);
                        $area_total_allocation = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $area_total_expense = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, 0, 0, $from_date, $to_date);
                        $area_total_balance = $area_total_allocation - $area_total_expense;
                        // echo "<pre>";print_r($expenseFilterHead);echo "</pre>";exit;
                        if ($expenseFilterHead) {
                            $child_serial = 1;
                            $parent_serial = 1;
                            $grand_child_serial = 1;
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_allocation = 0;
                            $grand_parent_total_expense = 0;
                            $grand_parent_total_balance = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_allocation = 0;
                            $parent_total_expense = 0;
                            $parent_total_balance = 0;
                            foreach ($expenseFilterHead as $expense_row) {
                                $a = array();
                                if (isset($child_serial) && $child_serial > 26):
                                    $child_serial = 1;
                                endif;
                                if (isset($grand_child_serial) && $grand_child_serial > 26):
                                    $grand_child_serial = 1;
                                endif;
                                if ($expense_row->level == 0):
                                    $grand_parent_child_counter = 0;
                                    $child_serial = 1;
                                    $head_serial_number = $parent_serial . ". ";
                                    if ($expense_row->has_child == 1):
                                        $parent_child_number = $expense_row->parent_head_child_number;
                                        $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $parent_total_expense = $expense_row->parent_head_total_expense;
                                        $parent_total_balance = $expense_row->parent_head_current_balance;
                                        $grand_parent_child_number = $expense_row->parent_head_child_number;
                                        $grand_parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $grand_parent_total_expense = $expense_row->parent_head_total_expense;
                                        $grand_parent_total_balance = $expense_row->parent_head_current_balance;
                                        $parent_child_counter = 0;
                                    endif;
                                    $parent_serial++;
                                endif;
                                if ($expense_row->level == 1):
                                    $grand_child_serial = 1;
                                    $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                    $child_serial++;
                                    if ($expense_row->has_child == 1):
                                        $parent_child_number = $expense_row->parent_head_child_number;
                                        $parent_total_allocation = $expense_row->parent_head_total_allocation;
                                        $parent_total_expense = $expense_row->parent_head_total_expense;
                                        $parent_total_balance = $expense_row->parent_head_current_balance;
                                        $parent_child_counter = 0;
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                    endif;
                                endif;
                                if ($expense_row->level == 2):
                                    $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                endif;
                                $a['Head Name'] = $head_serial_number . $expense_row->title;
                                if (isset($expense_row->total_allocation) && !empty($expense_row->total_allocation) && ($expense_row->has_child == 0)) {
                                    $a['Allocation'] = number_format($expense_row->total_allocation, 2);
                                } elseif (isset($expense_row->total_allocation) && empty($expense_row->total_allocation) && ($expense_row->has_child == 0)) {
                                    $a['Allocation'] = number_format(0.00, 2);
                                } else {
                                    $a['Allocation'] = '';
                                }
                                if (isset($expense_row->total_expense) && !empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                    $a['Expense'] = number_format($expense_row->total_expense, 2);
                                } elseif (isset($expense_row->total_expense) && empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                    $a['Expense'] = number_format(0.00, 2);
                                } else {
                                    $a['Expense'] = '';
                                }
                                if (isset($expense_row->head_current_balance) && !empty($expense_row->head_current_balance) && ($expense_row->has_child == 0)) {
                                    $a['Balance'] = number_format($expense_row->head_current_balance, 2);
                                } elseif (isset($expense_row->head_current_balance) && empty($expense_row->head_current_balance) && ($expense_row->has_child == 0)) {
                                    $a['Balance'] = number_format(0.00, 2);
                                } else {
                                    $a['Balance'] = '';
                                }
                                $data[] = (array) $a;
                                if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)):
                                    $parent_total['Head Name'] = "Total";
                                    $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                    $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                    $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                    $parent_total['Head Name'] = "    Total";
                                    $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                    $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                    $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                    $grand_parent_total['Head Name'] = "Total";
                                    $grand_parent_total['Allocation'] = number_format($grand_parent_total_allocation, 2);
                                    $grand_parent_total['Expense'] = number_format($grand_parent_total_expense, 2);
                                    $grand_parent_total['Balance'] = number_format($grand_parent_total_balance, 2);
                                    $data[] = (array) $grand_parent_total;
                                endif;
                            }
                            if ($head_row_id == -1):
                                $area_total['Head Name'] = "Total( " . $area_row_detail->title . " )";
                                $area_total['Allocation'] = number_format($area_total_allocation, 2);
                                $area_total['Expense'] = number_format($area_total_expense, 2);
                                $area_total['Balance'] = number_format($area_total_balance, 2);
                                $data[] = (array) $area_total;
                            endif;
                        }
                    } else {
                        /*
                         * Call For all head for all area
                         */
                        $area_name = "All_Area_" . $budget_year;
                        $area_list = $common_model->allAreas(1);
                        foreach ($area_list as $area) {
                            $total_allocation_by_area[$area->title] = $common_model->getTotalAllocationWithAdjustmentByArea($area->area_row_id, $budget_year, 0, 0);
                            $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                            $total_balance_by_area[$area->title] = $total_allocation_by_area[$area->title] - $total_expense_by_area[$area->title];
                        }
                        $grand_total_allocation = $common_model->getTotalAllocationWithAdjustmentByArea(-1, $budget_year, 0, 0);
                        $grand_total_expense = $common_model->getTotalExpenseByArea(-1, $budget_year, $from_date, $to_date);
                        $grand_total_balance = $grand_total_allocation - $grand_total_expense;
                        $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, true, $budget_year, $from_date, $to_date);
                        if ($expenseFilterHead) {
                            $child_serial = 1;
                            $parent_serial = 1;
                            $grand_child_serial = 1;
                            $grand_parent_child_number = 0;
                            $grand_parent_child_counter = 0;
                            $grand_parent_total_allocation = 0;
                            $grand_parent_total_expense = 0;
                            $grand_parent_total_balance = 0;
                            $parent_child_number = 0;
                            $parent_child_counter = 0;
                            $parent_total_allocation = 0;
                            $parent_total_expense = 0;
                            $parent_total_balance = 0;
                            foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                                if (isset($child_serial) && $child_serial > 26):
                                    $child_serial = 1;
                                endif;
                                if (isset($grand_child_serial) && $grand_child_serial > 26):
                                    $grand_child_serial = 1;
                                endif;
                                foreach ($expense_row as $area_expense_row) {
                                    $a = array();
                                    if ($area_expense_row['level'] == 0):
                                        $grand_parent_child_counter = 0;
                                        $child_serial = 1;
                                        $head_serial_number = $parent_serial . ". ";
                                        if ($area_expense_row['has_child'] == 1):
                                            $parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $grand_parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $grand_parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $parent_child_counter = 0;
                                        endif;
                                        $parent_serial++;
                                    endif;
                                    if ($area_expense_row['level'] == 1):
                                        $grand_child_serial = 1;
                                        $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                        $child_serial++;
                                        if ($area_expense_row['has_child'] == 1):
                                            $parent_child_number = $area_expense_row['parent_head_child_number'];
                                            $parent_total_allocation = $area_expense_row['parent_head_total_allocation'];
                                            $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                            $parent_total_balance = $area_expense_row['parent_head_current_balance'];
                                            $parent_child_counter = 0;
                                            $grand_parent_child_counter++;
                                        else:
                                            $parent_child_counter++;
                                        endif;
                                    endif;
                                    if ($area_expense_row['level'] == 2):
                                        $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                        $grand_child_serial++;
                                        $parent_child_counter++;
                                    endif;
                                    $a['Head Name'] = $head_serial_number . $area_expense_row['title'];
                                    $a['Area Name'] = $area_row_id_key;
                                    if (isset($area_expense_row['total_allocation']) && !empty($area_expense_row['total_allocation']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Allocation'] = number_format($area_expense_row['total_allocation'], 2);
                                    } elseif (isset($area_expense_row['total_allocation']) && empty($area_expense_row['total_allocation']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Allocation'] = number_format(0.00, 2);
                                    } else {
                                        $a['Allocation'] = '';
                                    }
                                    if (isset($area_expense_row['total_expense']) && !empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Expense'] = number_format($area_expense_row['total_expense'], 2);
                                    } elseif (isset($area_expense_row['total_expense']) && empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Expense'] = number_format(0.00, 2);
                                    } else {
                                        $a['Expense'] = '';
                                    }
                                    if (isset($area_expense_row['head_current_balance']) && !empty($area_expense_row['head_current_balance']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Balance'] = number_format($area_expense_row['head_current_balance'], 2);
                                    } elseif (isset($area_expense_row['head_current_balance']) && empty($area_expense_row['head_current_balance']) && ($area_expense_row['has_child'] == 0)) {
                                        $a['Balance'] = number_format(0.00, 2);
                                    } else {
                                        $a['Balance'] = '';
                                    }
                                    $data[] = (array) $a;
                                    if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)):
                                        $parent_total['Head Name'] = "Total";
                                        $parent_total['Area Name'] = '';
                                        $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                        $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                        $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                        $data[] = (array) $parent_total;
                                    endif;
                                    if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                        $parent_total['Head Name'] = "    Total";
                                        $parent_total['Area Name'] = '';
                                        $parent_total['Allocation'] = number_format($parent_total_allocation, 2);
                                        $parent_total['Expense'] = number_format($parent_total_expense, 2);
                                        $parent_total['Balance'] = number_format($parent_total_balance, 2);
                                        $data[] = (array) $parent_total;
                                    endif;
                                    if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                        $grand_parent_total['Head Name'] = "Total";
                                        $grand_parent_total['Area Name'] = '';
                                        $grand_parent_total['Allocation'] = number_format($grand_parent_total_allocation, 2);
                                        $grand_parent_total['Expense'] = number_format($grand_parent_total_expense, 2);
                                        $grand_parent_total['Balance'] = number_format($grand_parent_total_balance, 2);
                                        $data[] = (array) $grand_parent_total;
                                    endif;
                                }
                                if (($head_row_id == -1) && ($area_row_id == -1)):
                                    $area_total['Head Name'] = "Total( " . $area_row_id_key . " )";
                                    $area_total['Area Name'] = '';
                                    $area_total['Allocation'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                                    $area_total['Expense'] = number_format($total_expense_by_area[$area_row_id_key], 2);
                                    $area_total['Balance'] = number_format($total_balance_by_area[$area_row_id_key], 2);
                                    $data[] = (array) $area_total;
                                endif;
                                $parent_serial = 1;
                            }
                            if (($head_row_id == -1) && ($area_row_id == -1)):
                                $all_area_total['Head Name'] = "Grand Total( All Areas )";
                                $all_area_total['Area Name'] = '';
                                $all_area_total['Allocation'] = number_format($grand_total_allocation, 2);
                                $all_area_total['Expense'] = number_format($grand_total_expense, 2);
                                $all_area_total['Balance'] = number_format($grand_total_balance, 2);
                                $data[] = (array) $all_area_total;
                            endif;
                        }
                    }
                }
            }
            $data['account_expense_list'] = $data;
            $this->exportBalanceReportToCsv($data['account_expense_list'], $area_name);
        }
    }

    public function exportBalanceReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
