<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Head;
use App\Models\Area;
use App\Models\Expense;
use App\Libraries\Common;
use DB;
use Config;
use Session;

class ExpenseController extends Controller {

    private $viewFolderPath = 'expense/';

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
    public function index() {
        $data[] = '';
        $data['grand_total_expense'] = 0;
        $budget_year = date('Y');
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 1);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        $data['grand_total_expense'] = $common_model->getTotalExpenseByArea(-1, $budget_year, 0, 0);
        return view($this->viewFolderPath . 'expense_list', ['data' => $data]);
    }

    /**
     * Create new expense
     */
    public function createExpense(Request $request) {
        $data[] = '';
        $data['prev_budget_expense_area_row_id'] = '';
        if ($request->session()->has('budget_expense_area_row_id')) {
            $data['prev_budget_expense_area_row_id'] = $request->session()->get('budget_expense_area_row_id');
        }
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0, 1);
        $data['all_areas'] = $common_model->allAreas(1);
        return view($this->viewFolderPath . 'create_expense', ['data' => $data]);
    }

    /**
     * Expense List Detail
     * @param type $head_row_id
     * @return type
     */
    public function expenseDetails($head_row_id) {
        $data['expense_list'] = DB::table('expenses')->join('areas', 'expenses.area_row_id', '=', 'areas.area_row_id')->select('expenses.*', 'areas.*')->where('head_row_id', $head_row_id)->orderBy('expenses.expense_at', 'desc')->orderBy('areas.sort_order', 'asc')->get();
        $common_model = new Common();
        $head_row_detail = $common_model->get_head_row_info($head_row_id);
        $head_parent_list = $common_model->findHeadParent($head_row_id);
        $selected_head_hierarchy = $common_model->findHeadAncestorHierarchy($head_row_id);
        /*if (!count($head_parent_list)) {
            $selected_head_hierarchy = $head_row_detail->title;
        }
        if (isset($head_parent_list['head_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_parent']->title . " > " . $head_row_detail->title;
        }
        if (isset($head_parent_list['head_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_grand_parent']->title . " > " . $selected_head_hierarchy;
        }
        if (isset($head_parent_list['head_great_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_great_grand_parent']->title . " > " . $selected_head_hierarchy;
        }*/
        $data['head_name'] = $selected_head_hierarchy;
        return view($this->viewFolderPath . 'expense_head_details', ['data' => $data]);
    }

    /**
     * Update head expense
     * @param type $expense_row_id
     */
    public function edit($expense_row_id) {
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        $expense_row_detail = $common_model->get_expense_row_info($expense_row_id);
        $head_row_id = $expense_row_detail->head_row_id;
        $head_row_detail = $common_model->get_head_row_info($head_row_id);
        $head_parent_list = $common_model->findHeadParent($head_row_id);
        $selected_head_hierarchy = '';
        if (!count($head_parent_list)) {
            $selected_head_hierarchy = $head_row_detail->title;
        }
        if (isset($head_parent_list['head_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_parent']->title . " > " . $head_row_detail->title;
        }
        if (isset($head_parent_list['head_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_grand_parent']->title . " > " . $selected_head_hierarchy;
        }
        if (isset($head_parent_list['head_great_grand_parent'])) {
            $selected_head_hierarchy = $head_parent_list['head_great_grand_parent']->title . " > " . $selected_head_hierarchy;
        }
        $data['head_name'] = $selected_head_hierarchy;
        return view($this->viewFolderPath . 'edit_expense', ['expense_row_detail' => $expense_row_detail, 'data' => $data]);
    }

    /**
     * Store a new expense.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $common_model = new Common();
        $this->validate($request, [
            'area_row_id' => 'required',
            'head_row_id' => 'required',
            'budget_year' => 'required',
            'amount' => 'required',
            'expense_at' => 'required',
        ]);
        $total_expense_amount = 0;
        $area_row_id = $request->area_row_id;
        $head_row_id = $request->head_row_id;
        $budget_year = $request->budget_year;
        $expense_amount = $request->amount;
        $expense_remarks = $request->remarks;
        $expense_at = $request->expense_at;
        if (count($expense_amount) > 0) {
            foreach ($expense_amount as $key => $expense) {
                $total_expense_amount += $expense;
            }
        }
        $current_balance = $common_model->getHeadCurrentBalance($area_row_id, $head_row_id, $budget_year);
        if ($current_balance >= $total_expense_amount) {
            foreach ($expense_amount as $key => $expense) {
                $expense_model = new Expense();
                $expense_model->area_row_id = $area_row_id;
                $expense_model->head_row_id = $head_row_id;
                $expense_model->budget_year = $budget_year;
                $expense_model->amount = $expense;
                $expense_model->remarks = !empty($expense_remarks[$key]) ? $expense_remarks[$key] : '';
                $expense_model->created_by = Auth::user()->id;
                $expense_model->updated_by = Auth::user()->id;
                $expense_model->expense_at = date('Y-m-d', strtotime($request->expense_at[$key]));
                $expense_model->save();
            }
            if (!$request->session()->has('budget_expense_area_row_id')) {
                $request->session()->put('budget_expense_area_row_id', $area_row_id);
            } else {
                $prev_budget_expense_area_row_id = $request->session()->get('budget_expense_area_row_id');
                if ($prev_budget_expense_area_row_id != $area_row_id) {
                    $request->session()->put('budget_expense_area_row_id', $area_row_id);
                }
            }
            Session::flash('success-message', 'Successfully Performed !');
            return Redirect::to('/budgetExpense');
        } else {
            Session::flash('error-message', 'You Already Exced Allocation Amount !');
            return redirect::back()->withInput($request->all());
        }
    }

    public function update(Request $request, $expense_row_id) {
        $this->validate($request, [
            'area_row_id' => 'required',
            'head_row_id' => 'required',
            'budget_year' => 'required',
            'amount' => 'required',
        ]);
        $common_model = new Common();
        $expense = $common_model->get_expense_row_info($expense_row_id);
        $updated_expense_amount = $expense->amount;
        $area_row_id = $request->area_row_id;
        $head_row_id = $request->head_row_id;
        $budget_year = $request->budget_year;
        $expense_amount = $request->amount;
        $current_balance = $common_model->getHeadCurrentBalance($area_row_id, $head_row_id, $budget_year);
        $current_balance = $current_balance + $updated_expense_amount;
        $expense->area_row_id = $area_row_id;
        $expense->head_row_id = $head_row_id;
        $expense->budget_year = $budget_year;
        $expense->amount = $expense_amount;
        if ($request->remarks) {
            $expense->remarks = $request->remarks;
        } else {
            $expense->remarks = '';
        }
        $expense->updated_at = \Carbon\Carbon::now();
        $expense->updated_by = Auth::user()->id;
        if ($current_balance >= $expense_amount) {
            $expense->save();
            Session::flash('success-message', 'Successfully Performed !');
            return Redirect::to('/budgetExpense');
        } else {
            Session::flash('error-message', 'You Already Exced Allocation Amount !');
            return redirect::back()->withInput($request->all());
        }
    }

    /*
     * Remove an expense
     * $area_id area row id
     */

    public function destroy($expense_row_id) {
        if ($expense_row_id) {
            DB::table('expenses')->where('expense_row_id', $expense_row_id)->delete();
            Session::flash('success-message', 'Budget Head Expense Delete Successfully.');
        }
        return Redirect::to('/budgetExpense');
    }

}
