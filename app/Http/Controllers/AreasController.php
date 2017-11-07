<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Area;
use App\Libraries\Common;
use DB;
use Config;
use Session;

class AreasController extends Controller {

    private $viewFolderPath = 'areas/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the area List.
     *
     * @return arrea list object
     */
    public function index() {
        $data[] = '';
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas();
        //dd($all_records);
        return view($this->viewFolderPath . 'area_list', ['data' => $data]);
    }

    /**
     * Create new area
     */
    public function createArea() {
        return view($this->viewFolderPath . 'create_area');
    }

    /*
     * Edit Budget area
     * $area_id area_row_id
     */

    public function editArea($area_id) {
        $common_model = new Common();
        $area_row_detail = $common_model->get_area_row_info($area_id);
        return view($this->viewFolderPath . 'edit_area', ['area_row_detail' => $area_row_detail]);
    }

    /**
     * Store a new area.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'sort_order' => 'required',
        ]);
        $area_model = new Area();
        $area_model->title = $request->title;
        if ($request->area_code) {
            $area_model->area_code = $request->area_code;
        } else {
            $area_model->area_code = '';
        }
        if ($request->description) {
            $area_model->description = $request->description;
        } else {
            $area_model->description = '';
        }
        $area_model->sort_order = $request->sort_order;
        $area_model->created_by = Auth::user()->id;
        $area_model->updated_by = Auth::user()->id;
        $area_model->save();
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/areas');
    }

    /**
     * Update the given area.
     *
     * @param  Request  $request
     * @param  string  $area_id
     * @return Response
     */
    public function update(Request $request, $area_id) {
        $common_model = new Common();
        $area = $common_model->get_area_row_info($area_id);
        $area->title = $request->title;
        if ($request->description) {
            $area->description = $request->description;
        } else {
            $area->description = '';
        }
        if ($request->area_code) {
            $area->area_code = $request->area_code;
        } else {
            $area->area_code = '';
        }
        $area->sort_order = $request->sort_order;
        $area->updated_by = Auth::user()->id;
        $area->updated_at = \Carbon\Carbon::now();
        $area->save();
        Session::flash('success-message', 'Successfully Performed !');
        return Redirect::to('/areas');
    }

    /*
     * Remove an budget Area
     * $area_id area row id
     */

    public function destroy($area_id) {
        //DB::table('areas')->where('area_row_id', $area_id)->delete();
        if ($area_id) {
            $common_model = new Common();
            $area = $common_model->get_area_row_info($area_id);
            if ($area->status == 1) {
                DB::table('areas')
                        ->where('area_row_id', $area_id)
                        ->update([
                            'status' => 0
                ]);
                Session::flash('success-message', 'Area Inactive Successfully.');
            } else {
                DB::table('areas')
                        ->where('area_row_id', $area_id)
                        ->update([
                            'status' => 1
                ]);
                Session::flash('success-message', 'Area Active Successfully.');
            }
        }
        return Redirect::to('/areas');
    }

}
