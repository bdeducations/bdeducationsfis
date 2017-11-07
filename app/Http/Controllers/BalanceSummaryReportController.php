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

class BalanceSummaryReportController extends Controller {

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
        $data['all_heads'] = $common_model->allMainHeads();
        $all_area_list = $common_model->allAreaList(1);
        $data['all_area_list'] = $all_area_list;
        $month_list = $common_model->month_array;
        $data['month_list'] = $month_list;
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
                $area_list = $common_model->allAreas(1);
                $from_month = isset($request->from_month) ? $request->from_month : (int) date('m');
                $to_month = isset($request->to_month) ? $request->to_month : (int) date('m');
                $total_month = $to_month - $from_month + 1;
                $data['total_month'] = $total_month;
                $data['from_month'] = $from_month;
                $data['to_month'] = $to_month;
                $balance_report_by_month = $common_model->BudgetBalanceSummaryReportByMonthRange($area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
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
                        foreach ($area_list as $area_row) {
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
                return view($this->viewFolderPath . 'budget_balance_summary_report_by_month', ['data' => $data]);
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_summary_report', ['data' => $data]);
                    } else {
                        /* For All Area and specific head */
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        //dd($expenseFilterHead);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_summary_report_all_area', ['data' => $data]);
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        return view($this->viewFolderPath . 'budget_balance_summary_report', ['data' => $data]);
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        //dd($expenseFilterHead);
                        return view($this->viewFolderPath . 'budget_balance_summary_report_all_area', ['data' => $data]);
                    }
                }
            }
        } else {
            return view($this->viewFolderPath . 'budget_balance_summary_report', ['data' => $data]);
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
                $balance_report_by_month = $common_model->BudgetBalanceSummaryReportByMonthRange($area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
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
                $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_summary_report_by_month_pdf', ['data' => $data]);
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_summary_report_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_summary_report_pdf.pdf');
                    } else {
                        /* For All Area and specific head */
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_summary_report_all_area_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_summary_report_all_area_pdf.pdf');
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_summary_report_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_summary_report_pdf.pdf');
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
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        $data['account_expense_list'] = $expenseFilterHead;
                        //dd($expenseFilterHead);
                        $pdf = PDF::loadView($this->viewFolderPath . 'budget_balance_summary_report_all_area_pdf', ['data' => $data]);
                        return $pdf->stream('budget_balance_summary_report_all_area_pdf.pdf');
                    }
                }
            }
        }
    }

    public function downloadBalanceSummaryReportCsv(Request $request) {
        $expenseFilterHead = '';
        $data = array();
        $total_expense = 0;
        $total_allocation_by_area = array();
        $total_area_expense_by_month = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $total_allocation_by_area = array();
        $total_expense_by_area = array();
        $total_balance_by_area = array();
        $grand_total_expense_by_month_all_area = array();
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $area_row_id = $request->area_row_id;
            $head_row_id = $request->head_row_id;
            $date_type = $request->date_type;
            $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
            $common_model = new Common();
            $month_list = $common_model->month_array;
            $all_area_list = $common_model->allAreaList(1);
            $all_areas = $common_model->allAreas(1);
            if ($date_type == 1) {
                $from_month = $request->from_month;
                $to_month = $request->to_month;
                $start_month = $from_month;
                $total_month = $to_month - $from_month + 1;
                if ($head_row_id < 0) {
                    if ($area_row_id > 0) {
                        /** All Head for specific Area */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $total_allocation_by_area[$area_row_detail->area_row_id] = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
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
                $balance_report_by_month = $common_model->BudgetBalanceSummaryReportByMonthRange($area_row_id, $head_row_id, $budget_year, $from_month, $to_month);
                if ($balance_report_by_month) {
                    foreach ($balance_report_by_month as $area_row_id_key => $mothly_balance_row) {
                        foreach ($mothly_balance_row as $head_row_id_key => $area_balance_row) {
                            $a['Head Name'] = $area_balance_row['title'];
                            $a['Area Name'] = $all_area_list[$area_row_id_key];
                            $a['Allocation'] = number_format($area_balance_row['parent_head_total_allocation'], 2);
                            foreach ($area_balance_row[0] as $month_key => $monthly_expense_row) {
                                $month_name = $month_list[$month_key];
                                $a[$month_name] = number_format($monthly_expense_row, 2);
                            }
                            $a['Total Expense'] = number_format($area_balance_row['parent_head_total_expense'], 2);
                            $a['Balance'] = number_format($area_balance_row['parent_head_current_balance'], 2);
                            $data[] = (array) $a;
                        }
                        if ($head_row_id == -1) {
                            $a['Head Name'] = "Total";
                            $a['Area Name'] = $all_area_list[$area_row_id_key];
                            $a['Allocation'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                            for ($start_month = $from_month; $start_month <= $to_month; $start_month++) {
                                $month_name = $month_list[$start_month];
                                $a[$month_name] = number_format($total_area_expense_by_month[$area_row_id_key][$start_month], 2);
                            }
                            $a['Total Expense'] = number_format($total_expense_by_area[$area_row_id_key], 2);
                            $a['Balance'] = number_format($total_balance_by_area[$area_row_id_key], 2);
                            $data[] = (array) $a;
                            $area_name = $all_area_list[$area_row_id_key];
                        }
                    }
                    if($area_row_id == -1){
                        $area_name = "All_Areas";
                    }
                    if (($head_row_id == -1) && ($area_row_id == -1)) {
                        $a['Head Name'] = "Grand Total";
                        $a['Area Name'] = "All Areas";
                        $a['Allocation'] = number_format($grand_total_allocation_all_area, 2);
                        for ($start_month = $from_month; $start_month <= $to_month; $start_month++) {
                            $month_name = $month_list[$start_month];
                            $a[$month_name] = number_format($grand_total_expense_by_month_all_area[$start_month], 2);
                        }
                        $a['Total Expense'] = number_format($grand_total_expense_all_area, 2);
                        $a['Balance'] = number_format($grand_total_balance_all_area, 2);
                        $data[] = (array) $a;
                    }
                    $data['expense_list'] = $data;
                    $this->exportBalanceSummaryReportToCsv($data['expense_list'], $area_name);
                }
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
                    if ($area_row_id > 0) {
                        /**
                         * For specific area and specific head
                         */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $area_name = $area_row_detail->title;
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        foreach ($expenseFilterHead as $expense_row) {
                            $a['Head Name'] = $expense_row->title;
                            $a['Allocation'] = number_format($expense_row->parent_head_total_allocation, 2);
                            $a['Expense'] = number_format($expense_row->parent_head_total_expense, 2);
                            $a['Balance'] = number_format($expense_row->parent_head_current_balance, 2);
                            $data[] = (array) $a;
                        }
                        $data['expense_list'] = $data;
                        $this->exportBalanceSummaryReportToCsv($data['expense_list'], $area_name);
                    } else {
                        /**
                         * For all area and specific head
                         */
                        $area_name = "All_Area";
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        if (count($expenseFilterHead) > 0) {
                            foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                                foreach ($expense_row as $area_expense_row) {
                                    $a['Head Name'] = $area_expense_row['title'];
                                    $a['Area Name'] = $area_row_id_key;
                                    $a['Allocation'] = number_format($area_expense_row['parent_head_total_allocation'], 2);
                                    $a['Expense'] = number_format($area_expense_row['parent_head_total_expense'], 2);
                                    $a['Balance'] = number_format($area_expense_row['parent_head_current_balance'], 2);
                                    $data[] = (array) $a;
                                }
                            }
                        }
                        $area_name = "All_Area";
                        $data['expense_list'] = $data;
                        $this->exportBalanceSummaryReportToCsv($data['expense_list'], $area_name);
                    }
                } else {
                    if ($area_row_id > 0) {
                        /**
                         * For specific area and all head
                         */
                        $area_row_detail = $common_model->get_area_row_info($area_row_id);
                        $area_name = $area_row_detail->title;
                        $area_total_allocation = $common_model->getTotalAllocationWithAdjustmentByArea($area_row_id, $budget_year, 0, 0);
                        $area_total_expense = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, 0, 0, $from_date, $to_date);
                        $area_total_balance = $area_total_allocation - $area_total_expense;
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        foreach ($expenseFilterHead as $expense_row) {
                            $a['Head Name'] = $expense_row->title;
                            $a['Allocation'] = number_format($expense_row->parent_head_total_allocation, 2);
                            $a['Expense'] = number_format($expense_row->parent_head_total_expense, 2);
                            $a['Balance'] = number_format($expense_row->parent_head_current_balance, 2);
                            $data[] = (array) $a;
                        }
                        $total['Head Name'] = " Total " . "( " . $area_name . " )";
                        $total['Allocation'] = number_format($area_total_allocation, 2);
                        $total['Expense'] = number_format($area_total_expense, 2);
                        $total['Balance'] = number_format($area_total_balance, 2);
                        $data[] = (array) $total;
                        $data['expense_list'] = $data;
                        $this->exportBalanceSummaryReportToCsv($data['expense_list'], $area_name);
                    } else {
                        /**
                         * For all area and all head
                         */
                        $area_list = $common_model->allAreas(1);
                        foreach ($area_list as $area) {
                            $total_allocation_by_area[$area->title] = $common_model->getTotalAllocationWithAdjustmentByArea($area->area_row_id, $budget_year, 0, 0);
                            $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                            $total_balance_by_area[$area->title] = $total_allocation_by_area[$area->title] - $total_expense_by_area[$area->title];
                        }
                        $grand_total_allocation = $common_model->getTotalAllocationWithAdjustmentByArea(-1, $budget_year, 0, 0);
                        $grand_total_expense = $common_model->getTotalExpenseByArea(-1, $budget_year, $from_date, $to_date);
                        $grand_total_balance = $grand_total_allocation - $grand_total_expense;
                        $expenseFilterHead = $common_model->budgetBalanceSummaryByDate($area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                        if (count($expenseFilterHead) > 0) {
                            foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                                foreach ($expense_row as $area_expense_row) {
                                    $a['Head Name'] = $area_expense_row['title'];
                                    $a['Allocation'] = number_format($area_expense_row['parent_head_total_allocation'], 2);
                                    $a['Expense'] = number_format($area_expense_row['parent_head_total_expense'], 2);
                                    $a['Balance'] = number_format($area_expense_row['parent_head_current_balance'], 2);
                                    $data[] = (array) $a;
                                }
                                $total['Head Name'] = " Total " . "( " . $area_row_id_key . " )";
                                $total['Allocation'] = number_format($total_allocation_by_area[$area_row_id_key], 2);
                                $total['Expense'] = number_format($total_expense_by_area[$area_row_id_key], 2);
                                $total['Balance'] = number_format($total_balance_by_area[$area_row_id_key], 2);
                                $data[] = (array) $total;
                            }
                            $total['Head Name'] = " Grand Total( All Areas )";
                            $total['Allocation'] = number_format($grand_total_allocation, 2);
                            $total['Expense'] = number_format($grand_total_expense, 2);
                            $total['Balance'] = number_format($grand_total_balance, 2);
                            $data[] = (array) $total;
                        }
                        $area_name = "All_Area";
                        $data['expense_list'] = $data;
                        $this->exportBalanceSummaryReportToCsv($data['expense_list'], $area_name);
                    }
                }
            }
        }
    }

    public function exportBalanceSummaryReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
