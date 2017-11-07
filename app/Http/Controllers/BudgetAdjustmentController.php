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

class BudgetAdjustmentController extends Controller {

    private $viewFolderPath = 'budget_adjustment/';

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
        $data['grand_total_adjustment_reciption'] = 0;
        $budget_year = date('Y');
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        $data['account_adjustment_list'] = $common_model->allHeads(0, 0, 1);
        $data['grand_total_adjustment_reciption'] = $common_model->getTotalReception(-1, $budget_year, 0, 0);
        //dd($data['account_adjustment_list']);
        return view($this->viewFolderPath . 'budget_adjustment_index', ['data' => $data]);
    }

    /**
     * Adjustment Report List Detail
     * @param Request $request
     * @return array
     */
    public function details($head_row_id) {
        $data[] = '';
        $data['allocation_adjustment_list'] = '';
        $data['head_name'] = '';
        $data['area_list'] = '';
        if (isset($head_row_id)) {
            $budget_year = date('Y');
            $common_model = new Common();
            $area_list = $common_model->allAreaList(0);
            $head_row_detail = $common_model->get_head_row_info($head_row_id);
            $data['head_name'] = $common_model->getHeadAncestorHierarchy($head_row_id);
            $data['area_list'] = $area_list;
            $data['allocation_adjustment_list'] = DB::table('allocations')->join('areas', 'allocations.area_row_id', '=', 'areas.area_row_id')->select('allocations.*', 'areas.*')->where([['allocations.is_adjustment', '=', 1], ['allocations.budget_year', '=', $budget_year], ['allocations.head_row_id', '=', $head_row_id]])->orderBy('allocations.allocation_at', 'desc')->orderBy('areas.sort_order', 'asc')->get();
            //$data['allocation_adjustment_list'] = DB::table('allocations')->select('allocations.*')->where([['allocations.is_adjustment','=', 1],['allocations.budget_year','=', $budget_year],['allocations.head_row_id','=', $head_row_id]])->orderBy('allocations.allocation_row_id', 'desc')->get();
        }
        return view($this->viewFolderPath . 'allocation_adjustment_head_details', ['data' => $data])->with('common', $common_model);
    }

    /**
     * Update head allocation adjustment
     * @param type $allocation_row_id
     */
    public function edit($allocation_row_id) {
        $data[] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        $allocation_row_detail = $common_model->get_allocation_row_info($allocation_row_id);
        $head_row_id = $allocation_row_detail->head_row_id;
        $selected_head_hierarchy = $common_model->getHeadAncestorHierarchy($head_row_id);
        $data['head_name'] = $selected_head_hierarchy;
        return view($this->viewFolderPath . 'edit_allocation_adjustment', ['allocation_row_detail' => $allocation_row_detail, 'data' => $data]);
    }

    public function store(Request $request) {
        /**
         * is_adjustment value is always 1
         * For budget adjustment 
         */
        $is_adjustment = 1;
        $area_row_id = $request->area_row_id;
        $head_row_id = $request->head_row_id;
        $source_area_row_id = $request->source_area_row_id;
        $source_head_row_id = $request->source_head_row_id;
        $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
        $amount = $request->amount;
        $common_model = new Common();
        $head_current_balance = $common_model->getHeadCurrentBalance($source_area_row_id, $source_head_row_id, $budget_year);
        if (!empty($head_current_balance) && ($head_current_balance >= $amount)) {
            $this->validate($request, [
                'area_row_id' => 'required',
                'head_row_id' => 'required',
                'source_area_row_id' => 'required',
                'source_head_row_id' => 'required',
                'budget_year' => 'required',
                'amount' => 'required',
                'allocation_at' => 'required',
            ]);
            $allocation_model = new Allocation();
            $allocation_model->area_row_id = $area_row_id;
            $allocation_model->head_row_id = $head_row_id;
            $allocation_model->source_area_row_id = $source_area_row_id;
            $allocation_model->source_head_row_id = $source_head_row_id;
            $allocation_model->is_adjustment = $is_adjustment;
            $allocation_model->budget_year = $budget_year;
            $allocation_model->amount = $amount;
            if ($request->remarks) {
                $allocation_model->remarks = $request->remarks;
            } else {
                $allocation_model->remarks = '';
            }
            $allocation_model->allocation_at = date('Y-m-d', strtotime($request->allocation_at));
            $allocation_model->updated_by = Auth::user()->id;
            $allocation_model->updated_at = \Carbon\Carbon::now();
            $allocation_model->created_by = Auth::user()->id;
            $allocation_model->created_at = \Carbon\Carbon::now();
            $allocation_model->save();
            Session::flash('success-message', 'Successfully Performed !');
            return Redirect::to('/budget/adjustment');
        } else {
            Session::flash('error-message', 'Your Transfer Amount Exced Current Balance');
            return redirect::back()->withInput($request->all());
        }
    }

    /**
     * Update the given allocation adjustment.
     *
     * @param  Request  $request
     * @param  string  $allocation_row_id
     * @return Response
     */
    public function update(Request $request, $allocation_row_id) {
        $this->validate($request, [
            'area_row_id' => 'required',
            'head_row_id' => 'required',
            'source_area_row_id' => 'required',
            'source_head_row_id' => 'required',
            'budget_year' => 'required',
            'amount' => 'required',
            'allocation_at' => 'required',
        ]);
        $common_model = new Common();
        /**
         * is_adjustment value is always 1
         * For budget adjustment 
         */
        $area_row_id = $request->area_row_id;
        $head_row_id = $request->head_row_id;
        $source_area_row_id = $request->source_area_row_id;
        $source_head_row_id = $request->source_head_row_id;
        $budget_year = isset($request->budget_year) ? $request->budget_year : date('Y');
        $amount = $request->amount;
        $head_current_balance = $common_model->getHeadCurrentBalance($source_area_row_id, $source_head_row_id, $budget_year);
        if (!empty($head_current_balance) && ($head_current_balance >= $amount)) {
            $allocation = $common_model->get_allocation_row_info($allocation_row_id);
            $allocation->area_row_id = $area_row_id;
            $allocation->head_row_id = $head_row_id;
            $allocation->source_area_row_id = $source_area_row_id;
            $allocation->source_head_row_id = $source_head_row_id;
            $allocation->budget_year = $budget_year;
            $allocation->amount = $request->amount;
            if ($request->remarks) {
                $allocation->remarks = $request->remarks;
            } else {
                $allocation->remarks = '';
            }
            $allocation->allocation_at = date('Y-m-d', strtotime($request->allocation_at));
            $allocation->updated_by = Auth::user()->id;
            $allocation->updated_at = \Carbon\Carbon::now();
            $allocation->save();
            Session::flash('success-message', 'Successfully Performed !');
            return Redirect::to('/budget/adjustment');
        } else {
            Session::flash('error-message', 'Your Transfer Amount Exced Current Balance');
            return redirect::back()->withInput($request->all());
        }
    }

    /*
     * Remove an budget allocation
     * $area_id area row id
     */

    public function destroy($allocation_row_id) {
        if ($allocation_row_id) {
            DB::table('allocations')->where('allocation_row_id', $allocation_row_id)->delete();
            Session::flash('success-message', 'Budget Head Allocation Adjustment Delete Successfully.');
        }
        return Redirect::to('/budget/adjustment');
    }

}
