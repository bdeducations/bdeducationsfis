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

class AllocationController extends Controller {

    private $viewFolderPath = 'allocation/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the head List.
     *
     * @return head list object
     */
    public function index() {
        $data[] = '';
        $common_model = new Common();
        $data['grand_total_allocation'] = 0;
        $budget_year = date('Y');
        $data['all_heads'] = $common_model->allHeads(1, 0, 0, 0);
        //dd($data['all_heads']);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        $data['grand_total_allocation'] = $common_model->getTotalAllocation(-1, $budget_year, 0, 0);
        return view($this->viewFolderPath . 'allocation_list', ['data' => $data]);
    }

    /**
     * Create new area
     */
    public function createAllocation(Request $request) {
        $data[] = '';
        $data['prev_allocation_area_row_id'] = '';
        if ($request->session()->has('budget_allocation_area_row_id')) {
            $data['prev_allocation_area_row_id'] = $request->session()->get('budget_allocation_area_row_id');
        }
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0, 1);
        $data['all_areas'] = $common_model->allAreas(1);
        return view($this->viewFolderPath . 'create_allocation', ['data' => $data]);
    }

    /**
     * Allocation List Detail 
     * @param type $head_row_id
     * @return type
     */
    public function allocationDetails($head_row_id) {
        $data['allocation_list'] = DB::table('allocations')->join('areas', 'allocations.area_row_id', '=', 'areas.area_row_id')->select('allocations.*', 'areas.*')->where([['is_adjustment', '=', 0], ['head_row_id', '=', $head_row_id]])->orderBy('allocations.allocation_at', 'desc')->orderBy('areas.sort_order', 'asc')->get();
        $common_model = new Common();
        $head_row_detail = $common_model->get_head_row_info($head_row_id);
        $head_parent_list = $common_model->findHeadParent($head_row_id);
        $selected_head_hierarchy = '';
        if(!count($head_parent_list)){
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
        return view($this->viewFolderPath . 'allocation_head_details', ['data' => $data]);
    }

    /**
     * Update head allocation
     * @param type $allocation_row_id
     */
    public function edit($allocation_row_id) {
        $common_model = new Common();
        $data['all_heads'] = $common_model->allHeads(0, 0);
        $data['all_areas'] = $common_model->allAreas(1);
        $allocation_row_detail = $common_model->get_allocation_row_info($allocation_row_id);
        $head_row_id = $allocation_row_detail->head_row_id;
        $head_row_detail = $common_model->get_head_row_info($head_row_id);
        $head_parent_list = $common_model->findHeadParent($head_row_id);
        $selected_head_hierarchy = '';
        if(!count($head_parent_list)){
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
        return view($this->viewFolderPath . 'edit_allocation', ['allocation_row_detail' => $allocation_row_detail, 'data' => $data]);
    }

    /**
     * Store a new area.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'area_row_id' => 'required',
            'head_row_id' => 'required',
            'budget_year' => 'required',
            'amount' => 'required',
            'allocation_at' => 'required',
        ]);
        $allocation_model = new Allocation();
        $selected_area_row_id = $request->area_row_id;
        $allocation_model->area_row_id = $request->area_row_id;
        $allocation_model->head_row_id = $request->head_row_id;
        $allocation_model->budget_year = $request->budget_year;
        $allocation_model->source_area_row_id = 0;
        $allocation_model->source_head_row_id = 0;
        $allocation_model->is_adjustment = 0;
        $allocation_model->amount = $request->amount;
        if ($request->remarks) {
            $allocation_model->remarks = $request->remarks;
        } else {
            $allocation_model->remarks = '';
        }
        $allocation_model->allocation_at = date('Y-m-d', strtotime($request->allocation_at));
        $allocation_model->created_by = Auth::user()->id;
        $allocation_model->updated_by = Auth::user()->id;
        $allocation_model->save();
        if (!$request->session()->has('budget_allocation_area_row_id')) {
            $request->session()->put('budget_allocation_area_row_id', $selected_area_row_id);
        } else {
            $prev_allocation_area_row_id = $request->session()->get('budget_allocation_area_row_id');
            if ($prev_allocation_area_row_id != $selected_area_row_id) {
                $request->session()->put('budget_allocation_area_row_id', $selected_area_row_id);  
            }
        }
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/budgetAllocation');
    }

    /**
     * Update the given allocation.
     *
     * @param  Request  $request
     * @param  string  $allocation_row_id
     * @return Response
     */
    public function update(Request $request, $allocation_row_id) {
        $this->validate($request, [
            'area_row_id' => 'required',
            'head_row_id' => 'required',
            'budget_year' => 'required',
            'amount' => 'required',
        ]);
        $common_model = new Common();
        $allocation = $common_model->get_allocation_row_info($allocation_row_id);
        $allocation->area_row_id = $request->area_row_id;
        $allocation->head_row_id = $request->head_row_id;
        $allocation->budget_year = $request->budget_year;
        $allocation->amount = $request->amount;
        if ($request->remarks) {
            $allocation->remarks = $request->remarks;
        } else {
            $allocation->remarks = '';
        }
        $allocation->updated_by = Auth::user()->id;
        $allocation->updated_at = \Carbon\Carbon::now();
        $allocation->save();
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/budgetAllocation');
    }

    /*
     * Remove an budget allocation
     * $area_id area row id
     */

    public function destroy($allocation_row_id) {
        if ($allocation_row_id) {
            DB::table('allocations')->where('allocation_row_id', $allocation_row_id)->delete();
            Session::flash('success-message', 'Budget Head Allocation Delete Successfully.');
        }
        return Redirect::to('/budgetAllocation');
    }

}
