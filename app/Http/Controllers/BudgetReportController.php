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

class BudgetReportController extends Controller {

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
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id)) {
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
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $data['from_date'] = $from_date;
                $data['to_date'] = $to_date;
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $data['from_date'] = $to_date;
                $data['to_date'] = $to_date;
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } else {
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, 0, 0);
            }
        }
        $data['account_expense_list'] = $expenseFilterHead;
        return view($this->viewFolderPath . 'budget_expense_report', ['data' => $data]);
    }

    /**
     * Expense Report List Detail
     * @param Request $request
     * @return array
     */
    public function expenseReportDetails(Request $request) {
        $data[] = '';
        $data['expense_list'] = '';
        $data['head_name'] = '';
        $common_model = new Common();
        if (isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $head_row_id = $request->head_row_id;
            $area_row_id = $request->area_row_id;
            $budget_year = !empty($request->budget_year) ? $request->budget_year : date('Y');
            $data['selected_head_row_id'] = $head_row_id;
            $data['selected_area_row_id'] = $area_row_id;
            $data['selected_budget_year'] = $budget_year;
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
            if ($area_row_id > 0) {
                if (!empty($start_date) && !empty($end_date)) {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.area_row_id', '=', $area_row_id], ['expenses.budget_year', '=', $budget_year]])->whereBetween('expenses.expense_at', [$start_date, $end_date])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                } else {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.area_row_id', '=', $area_row_id], ['expenses.budget_year', '=', $budget_year]])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                }
            } else {
                if (!empty($start_date) && !empty($end_date)) {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.budget_year', '=', $budget_year]])->whereBetween('expenses.expense_at', [$start_date, $end_date])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                } else {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.budget_year', '=', $budget_year]])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                }
            }
            $data['head_name'] = $common_model->getHeadAncestorHierarchy($head_row_id);
        }
        return view($this->viewFolderPath . 'expense_report_head_details', ['data' => $data]);
    }

    public function expenseReportDetailsDownload(Request $request) {
        $data[] = '';
        $data['expense_list'] = '';
        $data['head_name'] = '';
        $common_model = new Common();
        if (isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $head_row_id = $request->head_row_id;
            $area_row_id = $request->area_row_id;
            $budget_year = !empty($request->budget_year) ? $request->budget_year : date('Y');
            $area_row_detail = $common_model->get_area_row_info($area_row_id);
            $data['area_row_detail'] = $area_row_detail;
            $data['selected_head_row_id'] = $head_row_id;
            $data['selected_area_row_id'] = $area_row_id;
            $data['selected_budget_year'] = $budget_year;
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
            if ($area_row_id > 0) {
                if (!empty($start_date) && !empty($end_date)) {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.area_row_id', '=', $area_row_id], ['expenses.budget_year', '=', $budget_year]])->whereBetween('expenses.expense_at', [$start_date, $end_date])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                } else {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.area_row_id', '=', $area_row_id], ['expenses.budget_year', '=', $budget_year]])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                }
            } else {
                if (!empty($start_date) && !empty($end_date)) {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.budget_year', '=', $budget_year]])->whereBetween('expenses.expense_at', [$start_date, $end_date])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                } else {
                    $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where([['expenses.head_row_id', '=', $head_row_id], ['expenses.budget_year', '=', $budget_year]])->orderBy('areas.sort_order', 'asc')->orderBy('expenses.expense_at', 'desc')->get();
                }
            }
            $data['head_name'] = $common_model->getHeadAncestorHierarchy($head_row_id);
        }
        $pdf = PDF::loadView($this->viewFolderPath . 'expense_report_details_pdf_download', ['data' => $data]);
        return $pdf->stream('Budget_Expense_Report_details.pdf');
    }

    /**
     * Expense Report PDF Download
     * @param Request $request
     */
    public function expenseReportDownload(Request $request) {
        $data[] = '';
        $expenseFilterHead = '';
        $common_model = new Common();
        if (isset($request->budget_year) && isset($request->head_row_id) && isset($request->area_row_id)) {
            $budget_year = $request->budget_year;
            $head_row_id = $request->head_row_id;
            $area_row_id = $request->area_row_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            if (!empty($from_date) && !empty($to_date)) {
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } elseif (!empty($from_date) && empty($to_date)) {
                $to_date = Carbon::now()->format('Y-m-d');
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } elseif (empty($from_date) && !empty($to_date)) {
                $from_date = $to_date;
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
            } else {
                $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, 0, 0);
            }
        }
        $data['filter_head_name'] = \App\Models\Head::where('head_row_id', $head_row_id)->first()->title;
        $area_row_detail = $common_model->get_area_row_info($area_row_id);
        $data['budget_year'] = $budget_year;
        $data['area_row_detail'] = $area_row_detail;
        $data['area_row_id'] = $area_row_id;
        $data['account_expense_list'] = $expenseFilterHead;
        $pdf = PDF::loadView($this->viewFolderPath . 'expense_report_pdf_download', ['data' => $data]);
        return $pdf->stream('Budget_Expense_Report.pdf');
        //return view($this->viewFolderPath . 'expense_report_pdf_download', ['data' => $data]);
    }

    public function allocationReport(Request $request) {
        $data[] = '';
        $allocationFilterHead = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['account_allocation_list'] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
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
            if ($head_row_id > 0) {
                /*
                 * Call For a specific head
                 */
                if ($area_row_id > 0) {
                    /* For specific area and specific head */
                    $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    return view($this->viewFolderPath . 'budget_expense_report_extended', ['data' => $data]);
                } else {
                    /* For All Area and specific head */
                    $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, false, $head_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    //echo "<pre>";print_r($expenseFilterHead); echo "</pre>";
                    return view($this->viewFolderPath . 'budget_expense_report_extended_all_area_single_head', ['data' => $data]);
                }
            } else {
                /*
                 * Call For all head
                 */
                if ($area_row_id > 0) {
                    /*
                     * Call For all head for a specific area
                     */
                    $expenseFilterHead = $common_model->expenseFilterAllHeads(false, true, false, $area_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    return view($this->viewFolderPath . 'budget_expense_report_extended', ['data' => $data]);
                } else {
                    /*
                     * Call For all head for all area
                     */
                    $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(false, true, false, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    return view($this->viewFolderPath . 'budget_expense_report_extended_all_area_all_head', ['data' => $data]);
                }
            }
        } else {
            return view($this->viewFolderPath . 'budget_allocation_report', ['data' => $data]);
        }
    }

    public function expenseReportExtended(Request $request) {
        $data[] = '';
        $expenseFilterHead = '';
        $data['grand_total_expense'] = 0;
        $data['area_row_title'] = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['selected_budget_year'] = '';
        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['account_expense_list'] = '';
        $data['total_area_expense_list'] = '';
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
            if ($head_row_id > 0) {
                /*
                 * Call For a specific head
                 */
                if ($area_row_id > 0) {
                    /* For specific area and specific head */
                    $area_row_detail = $common_model->get_area_row_info($area_row_id);
                    $data['area_row_title'] = $area_row_detail->title;
                    $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                    dd($expenseFilterHead);
                    $data['account_expense_list'] = $expenseFilterHead;
                    return view($this->viewFolderPath . 'budget_expense_report_extended', ['data' => $data]);
                } else {
                    /* For All Area and specific head */
                    $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, false, $head_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    //echo "<pre>";print_r($expenseFilterHead); echo "</pre>";
                    return view($this->viewFolderPath . 'budget_expense_report_extended_all_area_single_head', ['data' => $data]);
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
                    $data['area_row_title'] = $area_row_detail->title;
                    $total_expense_by_area = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, $from_date, $to_date);
                    $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, false, $area_row_id, $budget_year, $from_date, $to_date);
                    $data['total_expense_by_area'] = $total_expense_by_area;
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    return view($this->viewFolderPath . 'budget_expense_report_extended', ['data' => $data]);
                } else {
                    /*
                     * Call For all head for all area
                     */
                    $total_expense_by_area = array();
                    $data['grand_total_expense'] = $common_model->getTotalExpenseByArea(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                    $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, false, $budget_year, $from_date, $to_date);
                    $data['total_area_expense_list'] = $total_expense_by_area;
                    $data['account_expense_list'] = $expenseFilterHead;
                    //dd($expenseFilterHead);
                    return view($this->viewFolderPath . 'budget_expense_report_extended_all_area_all_head', ['data' => $data]);
                }
            }
        } else {
            return view($this->viewFolderPath . 'budget_expense_report_extended', ['data' => $data]);
        }
    }

    /**
     * Expense Report PDF Download
     * @param Request $request
     */
    public function expenseReportExtendedDownload(Request $request) {
        $data[] = '';
        $expenseFilterHead = '';
        $data['selected_head_row_id'] = '';
        $data['selected_area_row_id'] = '';
        $data['grand_total_expense'] = 0;
        $common_model = new Common();
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        if (isset($request->budget_year) && isset($request->head_row_id) && isset($request->area_row_id)) {
            $budget_year = $request->budget_year;
            $head_row_id = $request->head_row_id;
            $area_row_id = $request->area_row_id;
            if ($area_row_id > 0) {
                $data['area_number_count'] = 1;
            } else {
                $data['area_number_count'] = $common_model->area_number_count();
            }
            $area_row_detail = $common_model->get_area_row_info($area_row_id);
            $data['selected_area_row_id'] = $request->area_row_id;
            $data['selected_head_row_id'] = $request->head_row_id;
            $data['budget_year'] = $budget_year;
            $data['area_row_detail'] = $area_row_detail;
            $data['area_row_id'] = $area_row_id;
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
                    /**
                     * Call for a specific head and specific area
                     */
                    $area_row_detail = $common_model->get_area_row_info($area_row_id);
                    $data['area_row_title'] = $area_row_detail->title;
                    $data['filter_head_name'] = \App\Models\Head::where('head_row_id', $head_row_id)->first()->title;
                    $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    $pdf = PDF::loadView($this->viewFolderPath . 'expense_report_extended_pdf_download', ['data' => $data]);
                    //$pdf->setPaper('legal', 'landscape');
                    return $pdf->stream('Budget_Expense_Report_extended.pdf');
                } else {
                    /**
                     * Call for a specific head and all area
                     */
                    $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, false, $head_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    $pdf = PDF::loadView($this->viewFolderPath . 'budget_expense_report_extended_all_area_single_head_pdf', ['data' => $data]);
                    //$pdf->setPaper('legal', 'landscape');
                    return $pdf->stream('Budget_Expense_Report_extended_all_area_single_head.pdf');
                }
            } else {
                /*
                 * Call For all head
                 */
                if ($area_row_id > 0) {
                    /**
                     * Call for all head and specific area
                     */
                    $area_row_detail = $common_model->get_area_row_info($area_row_id);
                    $data['area_row_title'] = $area_row_detail->title;
                    $total_expense_by_area = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, $from_date, $to_date);
                    $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, false, $area_row_id, $budget_year, $from_date, $to_date);
                    $data['account_expense_list'] = $expenseFilterHead;
                    $data['total_expense_by_area'] = $total_expense_by_area;
                    $pdf = PDF::loadView($this->viewFolderPath . 'expense_report_extended_pdf_download', ['data' => $data]);
                    //$pdf->setPaper('legal', 'landscape');
                    return $pdf->stream('Budget_Expense_Report_extended.pdf');
                } else {
                    /**
                     * Call for a all head and all area
                     */
                    $total_expense_by_area = array();
                    $data['grand_total_expense'] = $common_model->getTotalExpenseByArea(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                    $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, false, $budget_year, $from_date, $to_date);
                    $data['total_area_expense_list'] = $total_expense_by_area;
                    $data['account_expense_list'] = $expenseFilterHead;
                    $pdf = PDF::loadView($this->viewFolderPath . 'budget_expense_report_extended_all_area_single_head_pdf', ['data' => $data]);
                    //$pdf->setPaper('legal', 'landscape');
                    return $pdf->stream('Budget_Expense_Report_extended_all_area_all_head.pdf');
                }
            }
        }
    }

    public function expenseReportExtendedCSVDownload(Request $request) {
        $expenseFilterHead = '';
        $grand_total_expense = 0;
        $common_model = new Common();
        $alphabets = $common_model->alphabet_array;
        $roman = $common_model->roman_array;
        if ($request->isMethod('GET') && isset($request->head_row_id) && isset($request->area_row_id) && isset($request->budget_year)) {
            $budget_year = $request->budget_year;
            $head_row_id = $request->head_row_id;
            $area_row_id = $request->area_row_id;
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
                    /**
                     * Call for a specific head and specific area
                     */
                    $area_row_detail = $common_model->get_area_row_info($area_row_id);
                    $area_name = str_replace(" ", "_", $area_row_detail->title) . "_" . $budget_year;
                    $expenseFilterHead = $common_model->expenseFilterHeads(true, true, false, $area_row_id, $head_row_id, $budget_year, $from_date, $to_date);
                    if ($expenseFilterHead) {
                        $child_serial = 1;
                        $parent_serial = 1;
                        $grand_child_serial = 1;
                        $grand_parent_child_number = 0;
                        $grand_parent_child_counter = 0;
                        $grand_parent_total_expense = 0;
                        $parent_child_number = 0;
                        $parent_child_counter = 0;
                        $parent_total_expense = 0;
                        foreach ($expenseFilterHead as $expense_row) {
                            $a = array();
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            if ($expense_row->level == 0) {
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                $head_serial_number = $parent_serial . ". ";
                                $parent_serial++;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $grand_parent_child_number = $expense_row->parent_head_child_number;
                                    $grand_parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_child_counter = 0;
                                endif;
                            }
                            if ($expense_row->level == 1) {
                                $grand_child_serial = 1;
                                $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                $child_serial++;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_child_counter = 0;
                                    $grand_parent_child_counter++;
                                else:
                                    $parent_child_counter++;
                                endif;
                            }
                            if ($expense_row->level == 2) {
                                $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                $grand_child_serial++;
                                $parent_child_counter++;
                            }
                            $a['Head Name'] = $head_serial_number . $expense_row->title;
                            if (isset($expense_row->total_expense) && !empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                $a['Expense amount'] = number_format($expense_row->total_expense, 2);
                            } elseif (isset($expense_row->total_expense) && empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                $a['Expense amount'] = number_format(0.00, 2);
                            } else {
                                $a['Expense amount'] = '';
                            }
                            $data[] = (array) $a;
                            if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)):
                                $parent_total['Head Name'] = "Total";
                                $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                $parent_total['Head Name'] = "    Total";
                                $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                $grand_parent_total['Head Name'] = "Total";
                                $grand_parent_total['Expense amount'] = number_format($grand_parent_total_expense, 2);
                                $data[] = (array) $grand_parent_total;
                            endif;
                        }
                    }
                } else {
                    /**
                     * Call for a specific head and all area
                     */
                    $expenseFilterHead = $common_model->expenseFilterAllAreaSingleHead(true, true, false, $head_row_id, $budget_year, $from_date, $to_date);
                    $area_name = "All_Area_" . $budget_year;
                    if ($expenseFilterHead) {
                        $child_serial = 1;
                        $parent_serial = 1;
                        $grand_child_serial = 1;
                        $grand_parent_child_number = 0;
                        $grand_parent_child_counter = 0;
                        $grand_parent_total_expense = 0;
                        $parent_child_number = 0;
                        $parent_child_counter = 0;
                        $parent_total_expense = 0;
                        foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            foreach ($expense_row as $area_expense_row) {
                                $a = array();
                                if ($area_expense_row['level'] == 0) {
                                    $grand_parent_child_counter = 0;
                                    $child_serial = 1;
                                    $head_serial_number = $parent_serial . ". ";
                                    $parent_serial++;
                                    if ($area_expense_row['has_child'] == 1):
                                        $parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $parent_child_counter = 0;
                                    endif;
                                }
                                if ($area_expense_row['level'] == 1) {
                                    $grand_child_serial = 1;
                                    $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                    $child_serial++;
                                    if ($area_expense_row['has_child'] == 1):
                                        $parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $parent_child_counter = 0;
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                    endif;
                                }
                                if ($area_expense_row['level'] == 2) {
                                    $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                }
                                $a['Head Name'] = $head_serial_number . $area_expense_row['title'];
                                $a['Area Name'] = $area_row_id_key;
                                if (isset($area_expense_row['total_expense']) && !empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                    $a['Expense amount'] = number_format($area_expense_row['total_expense'], 2);
                                } elseif (isset($area_expense_row['total_expense']) && empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                    $a['Expense amount'] = number_format(0.00, 2);
                                } else {
                                    $a['Expense amount'] = '';
                                }
                                $data[] = (array) $a;
                                if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)):
                                    $parent_total['Head Name'] = "Total";
                                    $parent_total['Area Name'] = '';
                                    $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                    $parent_child_total['Head Name'] = "    Total";
                                    $parent_child_total['Area Name'] = '';
                                    $parent_child_total['Expense amount'] = number_format($parent_total_expense, 2);
                                    $data[] = (array) $parent_child_total;
                                endif;
                                if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                    $grand_parent_total['Head Name'] = "Total";
                                    $grand_parent_total['Area Name'] = '';
                                    $grand_parent_total['Expense amount'] = number_format($grand_parent_total_expense, 2);
                                    $data[] = (array) $grand_parent_total;
                                endif;
                            }
                            $parent_serial = 1;
                        }
                    }
                }
            } else {
                /*
                 * Call For all head
                 */
                if ($area_row_id > 0) {
                    /**
                     * Call for all head and specific area
                     */
                    $area_row_detail = $common_model->get_area_row_info($area_row_id);
                    $area_name = str_replace(" ", "_", $area_row_detail->title) . "_" . $budget_year;
                    $total_expense_by_area = $common_model->getTotalExpenseByArea($area_row_id, $budget_year, $from_date, $to_date);
                    $expenseFilterHead = $common_model->expenseFilterAllHeads(true, true, false, $area_row_id, $budget_year, $from_date, $to_date);
                    if ($expenseFilterHead) {
                        $child_serial = 1;
                        $parent_serial = 1;
                        $grand_child_serial = 1;
                        $grand_parent_child_number = 0;
                        $grand_parent_child_counter = 0;
                        $grand_parent_total_expense = 0;
                        $parent_child_number = 0;
                        $parent_child_counter = 0;
                        $parent_total_expense = 0;
                        foreach ($expenseFilterHead as $expense_row) {
                            $a = array();
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            if ($expense_row->level == 0) {
                                $grand_parent_child_counter = 0;
                                $child_serial = 1;
                                $head_serial_number = $parent_serial . ". ";
                                $parent_serial++;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $grand_parent_child_number = $expense_row->parent_head_child_number;
                                    $grand_parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_child_counter = 0;
                                endif;
                            }
                            if ($expense_row->level == 1) {
                                $grand_child_serial = 1;
                                $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                $child_serial++;
                                if ($expense_row->has_child == 1):
                                    $parent_child_number = $expense_row->parent_head_child_number;
                                    $parent_total_expense = $expense_row->parent_head_total_expense;
                                    $parent_child_counter = 0;
                                    $grand_parent_child_counter++;
                                else:
                                    $parent_child_counter++;
                                endif;
                            }
                            if ($expense_row->level == 2) {
                                $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                $grand_child_serial++;
                                $parent_child_counter++;
                            }
                            $a['Head Name'] = $head_serial_number . $expense_row->title;
                            if (isset($expense_row->total_expense) && !empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                $a['Expense amount'] = number_format($expense_row->total_expense, 2);
                            } elseif (isset($expense_row->total_expense) && empty($expense_row->total_expense) && ($expense_row->has_child == 0)) {
                                $a['Expense amount'] = number_format(0.00, 2);
                            } else {
                                $a['Expense amount'] = '';
                            }
                            $data[] = (array) $a;
                            if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 1) && ($expense_row->has_child == 0)):
                                $parent_total['Head Name'] = "Total";
                                $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                $parent_total['Head Name'] = "    Total";
                                $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                $data[] = (array) $parent_total;
                            endif;
                            if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($expense_row->level == 2) && ($expense_row->has_child == 0)):
                                $grand_parent_total['Head Name'] = "Total";
                                $grand_parent_total['Expense amount'] = number_format($grand_parent_total_expense, 2);
                                $data[] = (array) $grand_parent_total;
                            endif;
                        }
                        if ($head_row_id == -1):
                            $area_total['Head Name'] = "Total( " . $area_row_detail->title . " )";
                            $area_total['Expense amount'] = number_format($total_expense_by_area, 2);
                            $data[] = (array) $area_total;
                        endif;
                        $parent_serial = 1;
                    }
                } else {
                    /**
                     * Call for a all head and all area
                     */
                    $total_expense_by_area = array();
                    $grand_total_expense = $common_model->getTotalExpenseByArea(-1, $budget_year, 0, 0);
                    $area_list = $common_model->allAreas(1);
                    foreach ($area_list as $area) {
                        $total_expense_by_area[$area->title] = $common_model->getTotalExpenseByArea($area->area_row_id, $budget_year, $from_date, $to_date);
                    }
                    $expenseFilterHead = $common_model->expenseFilterAllHeadAllArea(true, true, false, $budget_year, $from_date, $to_date);
                    $area_name = "All_Area_" . $budget_year;
                    if ($expenseFilterHead) {
                        $child_serial = 1;
                        $parent_serial = 1;
                        $grand_child_serial = 1;
                        $grand_parent_child_number = 0;
                        $grand_parent_child_counter = 0;
                        $grand_parent_total_expense = 0;
                        $parent_child_number = 0;
                        $parent_child_counter = 0;
                        $parent_total_expense = 0;
                        foreach ($expenseFilterHead as $area_row_id_key => $expense_row) {
                            if (isset($child_serial) && $child_serial > 26):
                                $child_serial = 1;
                            endif;
                            if (isset($grand_child_serial) && $grand_child_serial > 26):
                                $grand_child_serial = 1;
                            endif;
                            foreach ($expense_row as $area_expense_row) {
                                $a = array();
                                if ($area_expense_row['level'] == 0) {
                                    $grand_parent_child_counter = 0;
                                    $child_serial = 1;
                                    $head_serial_number = $parent_serial . ". ";
                                    $parent_serial++;
                                    if ($area_expense_row['has_child'] == 1):
                                        $parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $grand_parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $grand_parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $parent_child_counter = 0;
                                    endif;
                                }
                                if ($area_expense_row['level'] == 1) {
                                    $grand_child_serial = 1;
                                    $head_serial_number = "   " . $alphabets[$child_serial] . ". ";
                                    $child_serial++;
                                    if ($area_expense_row['has_child'] == 1):
                                        $parent_child_number = $area_expense_row['parent_head_child_number'];
                                        $parent_total_expense = $area_expense_row['parent_head_total_expense'];
                                        $parent_child_counter = 0;
                                        $grand_parent_child_counter++;
                                    else:
                                        $parent_child_counter++;
                                    endif;
                                }
                                if ($area_expense_row['level'] == 2) {
                                    $head_serial_number = "     " . $roman[$grand_child_serial] . ". ";
                                    $grand_child_serial++;
                                    $parent_child_counter++;
                                }
                                $a['Head Name'] = $head_serial_number . $area_expense_row['title'];
                                $a['Area Name'] = $area_row_id_key;
                                if (isset($area_expense_row['total_expense']) && !empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                    $a['Expense amount'] = number_format($area_expense_row['total_expense'], 2);
                                } elseif (isset($area_expense_row['total_expense']) && empty($area_expense_row['total_expense']) && ($area_expense_row['has_child'] == 0)) {
                                    $a['Expense amount'] = number_format(0.00, 2);
                                } else {
                                    $a['Expense amount'] = '';
                                }
                                $data[] = (array) $a;
                                if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 1) && ($area_expense_row['has_child'] == 0)):
                                    $parent_total['Head Name'] = "Total";
                                    $parent_total['Area Name'] = '';
                                    $parent_total['Expense amount'] = number_format($parent_total_expense, 2);
                                    $data[] = (array) $parent_total;
                                endif;
                                if (($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                    $parent_child_total['Head Name'] = "    Total";
                                    $parent_child_total['Area Name'] = '';
                                    $parent_child_total['Expense amount'] = number_format($parent_total_expense, 2);
                                    $data[] = (array) $parent_child_total;
                                endif;
                                if (($grand_parent_child_number == $grand_parent_child_counter) && ($parent_child_number == $parent_child_counter) && ($area_expense_row['level'] == 2) && ($area_expense_row['has_child'] == 0)):
                                    $grand_parent_total['Head Name'] = "Total";
                                    $grand_parent_total['Area Name'] = '';
                                    $grand_parent_total['Expense amount'] = number_format($grand_parent_total_expense, 2);
                                    $data[] = (array) $grand_parent_total;
                                endif;
                            }
                            if ($head_row_id == -1):
                                $area_total['Head Name'] = "Total( " . $area_row_id_key . " )";
                                $area_total['Area Name'] = '';
                                $area_total['Expense amount'] = number_format($total_expense_by_area[$area_row_id_key], 2);
                                $data[] = (array) $area_total;
                            endif;
                            $parent_serial = 1;
                        }
                        if (($head_row_id == -1) && ($area_row_id == -1)):
                            $all_area_total['Head Name'] = "Grand Total( All Areas )";
                            $all_area_total['Area Name'] = '';
                            $all_area_total['Expense amount'] = number_format($grand_total_expense, 2);
                            $data[] = (array) $all_area_total;
                        endif;
                    }
                }
            }
            $data['account_expense_list'] = $data;
            /* echo "<pre>";
              print_r($data['account_expense_list']);
              die;
              echo "</pre>"; */
            $this->exportExpenseReportToCsv($data['account_expense_list'], $area_name);
        }
    }

    public function exportExpenseReportToCsv($data, $file_name) {
        $excel_file_name = $file_name . "_" . time();
        Excel::create($excel_file_name, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('csv');
        exit;
    }

}
