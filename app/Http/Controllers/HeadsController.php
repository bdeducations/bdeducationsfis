<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Head;
use App\Libraries\Common;
use DB;
use Config;
use Session;

class HeadsController extends Controller {

    private $viewFolderPath = 'heads/';

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
        $data['all_heads'] = $common_model->budgetAllHeadListWithProject(0);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        return view($this->viewFolderPath . 'head_list', ['data' => $data]);
    }

    public function getHeadListByYear($selected_budget_year = 0, $selected_head_row_id = null) {
        $common_model = new Common();
        $head_drop_down = $common_model->getBudgetHeadList($selected_budget_year, 1, $selected_head_row_id);
        echo $head_drop_down;
    }

    public function getHeadListByYearForReport($selected_budget_year = 0, $selected_head_row_id = null) {
        $common_model = new Common();
        $head_drop_down = $common_model->getBudgetHeadListForReport($selected_budget_year, 1, $selected_head_row_id);
        echo $head_drop_down;
    }

    /**
     * Create new area
     */
    public function createHead() {
        $data[] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->budgetGeneralHeadList(0);
        return view($this->viewFolderPath . 'create_head', ['data' => $data]);
    }

    /*
     * Edit Budget area
     * $area_id area_row_id
     */

    public function editHead($head_row_id) {
        $data[] = '';
        $common_model = new Common();
        $data['all_heads'] = $common_model->budgetGeneralHeadList(0);
        $head_row_detail = $common_model->get_head_row_info($head_row_id);
        return view($this->viewFolderPath . 'edit_head', ['head_row_detail' => $head_row_detail, 'data' => $data]);
    }

    /**
     * Store a new area.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'parent_id' => 'required',
            'title' => 'required',
            'sort_order' => 'required',
        ]);
        $head_model = new Head();
        $head_model->title = $request->title;
        $head_model->parent_id = $request->parent_id;
        if ($request->description) {
            $head_model->description = $request->description;
        } else {
            $head_model->description = '';
        }
        $head_model->sort_order = $request->sort_order;
        $head_model->created_by = Auth::user()->id;
        $head_model->updated_by = Auth::user()->id;
        /**
         * get level,
         * level = parent level + 1.
         * If main head level ~ 0
         */
        $head_model->level = 0;
        if ($head_model->parent_id) {
            $parent_head_info = DB::table('heads')->where('head_row_id', $head_model->parent_id)->first();
            $head_model->level = $parent_head_info->level + 1;
        }
        $head_model->save();
        /**
         * update parent has_child status
         */
        if ($head_model->parent_id) {
            if ($parent_head_info->has_child != 1) {
                DB::table('heads')
                        ->where('head_row_id', $request->parent_id)
                        ->update([
                            'has_child' => 1
                ]);
            }
        }
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/budgetHeads');
    }

    /**
     * Update the given area.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $head_row_id) {
        $this->validate($request, [
            'parent_id' => 'required',
            'title' => 'required',
            'sort_order' => 'required',
        ]);
        $common_model = new Common();
        $head = $common_model->get_head_row_info($head_row_id);
        $old_parent_id = $head->parent_id;
        $new_parent_id = $request->parent_id;
        $head->title = $request->title;
        $head->parent_id = $request->parent_id;
        if ($request->description) {
            $head->description = $request->description;
        } else {
            $head->description = '';
        }
        $head->sort_order = $request->sort_order;
        $head->updated_by = Auth::user()->id;
        /**
         * get level,
         * level = parent level + 1.
         * If main head level ~ 0
         */
        $head->level = 0;
        if ($head->parent_id) {
            $parent_head_info = DB::table('heads')->where('head_row_id', $head->parent_id)->first();
            $head->level = $parent_head_info->level + 1;
        }
        $head->save();
        /**
         * update parent has_child status
         */
        if ($head->parent_id) {
            if ($parent_head_info->has_child != 1) {
                DB::table('heads')
                        ->where('head_row_id', $request->parent_id)
                        ->update([
                            'has_child' => 1
                ]);
            }
        }
        /**
         * Update old parent has_child status
         */
        if ($old_parent_id != $new_parent_id) {
            $old_parent_head_child = DB::table('heads')->where('parent_id', $old_parent_id)->first();
            if ($old_parent_head_child) {
                DB::table('heads')
                        ->where('head_row_id', $old_parent_id)
                        ->update([
                            'has_child' => 1
                ]);
            } else {
                DB::table('heads')
                        ->where('head_row_id', $old_parent_id)
                        ->update([
                            'has_child' => 0
                ]);
            }
        }
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/budgetHeads');
    }

    /**
     * Get ancestor head hierarchy for selected head
     * @param type $head_row_id
     */
    public function getHeadAncestor($head_row_id) {
        $selected_head_hierarchy = '';
        if (isset($head_row_id)) {
            $common_model = new Common();
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
            echo $selected_head_hierarchy;
        }
    }

    /*
     * Remove an budget Area
     * $area_id area row id
     */

    public function destroy($head_row_id) {
        if ($head_row_id) {
            //DB::table('heads')->where('head_row_id', $head_row_id)->delete();
            $common_model = new Common();
            $head_row_detail = $common_model->get_head_row_info($head_row_id);
            if ($head_row_detail->status == 1) {
                DB::table('heads')
                        ->where('head_row_id', $head_row_id)
                        ->update([
                            'status' => 0
                ]);
                Session::flash('success-message', 'Budget Head Inactive Successfully.');
            } else {
                DB::table('heads')
                        ->where('head_row_id', $head_row_id)
                        ->update([
                            'status' => 1
                ]);
                Session::flash('success-message', 'Budget Head Active Successfully.');
            }
        }
        return Redirect::to('/budgetHeads');
    }

}
