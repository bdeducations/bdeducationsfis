<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Head;
use App\Models\ProjectHead;
use App\Libraries\Common;
use DB;
use Config;
use Session;

class ProjectHeadsController extends Controller {

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
     * Show the project head List.
     *
     * @return project head list object
     */
    public function index() {
        $data[] = '';
        $budget_year = date('Y');
        $common_model = new Common();
        $data['all_heads'] = $common_model->budgetProjectHeadList($budget_year);
        $data['alphabets'] = $common_model->alphabet_array;
        $data['roman'] = $common_model->roman_array;
        //dd($data['alphabets']);
        return view($this->viewFolderPath . 'project_head_list', ['data' => $data]);
    }

    /**
     * Create new project head
     */
    public function create() {
        $data[] = '';
        $budget_year = date('Y');
        $common_model = new Common();
        $data['all_heads'] = $common_model->budgetProjectHeadList($budget_year);
        return view($this->viewFolderPath . 'create_project_head', ['data' => $data]);
    }

    /*
     * Edit Budget area
     * $area_id area_row_id
     */

    public function edit($head_row_id) {
        $data[] = '';
        $budget_year = date('Y');
        $common_model = new Common();
        $data['all_heads'] = $common_model->budgetProjectHeadList($budget_year);
        $head_row_detail = $common_model->get_project_head_row_info($head_row_id);
        return view($this->viewFolderPath . 'edit_project_head', ['head_row_detail' => $head_row_detail, 'data' => $data]);
    }

    /**
     * Store a new project head.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'budget_year' => 'required',
            'parent_id' => 'required',
            'title' => 'required',
            'sort_order' => 'required',
        ]);
        $ProjectHead = new ProjectHead();
        $Head = new Head();
        $Head->title = $request->title;
        $Head->parent_id = $request->parent_id;
        if ($request->description) {
            $Head->description = $request->description;
        } else {
            $Head->description = '';
        }
        $Head->is_project = 1;
        $Head->sort_order = $request->sort_order;
        $Head->created_by = Auth::user()->id;
        $Head->updated_by = Auth::user()->id;
        /**
         * get level,
         * level = parent level + 1.
         * If main head level ~ 0
         */
        $Head->level = 0;
        if ($Head->parent_id) {
            $parent_head_info = DB::table('heads')->where('head_row_id', $Head->parent_id)->first();
            $Head->level = $parent_head_info->level + 1;
        }
        $Head->save();
        
        /**
         * add in project head table
         */
        $ProjectHead->head_row_id = $Head->head_row_id;
        $ProjectHead->budget_year = $request->budget_year;
        $ProjectHead->save();
        /**
         * update parent has_child status 
         */
        if ($Head->parent_id) {
            if ($parent_head_info->has_child != 1) {
                DB::table('heads')
                        ->where('head_row_id', $request->parent_id)
                        ->update([
                            'has_child' => 1
                ]);
            }
        }
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/budget/project/head');
    }

    /**
     * Update the given project head.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $head_row_id) {
        $this->validate($request, [
            'budget_year' => 'required',
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
        $head->is_project = 1;
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
        return Redirect::to('/budget/project/head');
    }

   /*
     * Remove an budget project head
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
                Session::flash('success-message', 'Project Head Inactive Successfully.');
            } else {
                DB::table('heads')
                        ->where('head_row_id', $head_row_id)
                        ->update([
                            'status' => 1
                ]);
                Session::flash('success-message', 'Budget Head Active Successfully.');
            }
        }
        return Redirect::to('/budget/project/head');
    }

}
