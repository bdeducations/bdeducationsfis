<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Libraries\TrustMIS;
use \App\Libraries\HrCommon;
use \App\Models\HrEmployeePerformanceComments;
use DB;
use Config;
use Session;

class ManagePerformanceController extends Controller {

    private $viewFolderPath = 'hr/';

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $data[] = '';
        $common_model = new HrCommon();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['performance_records'] = $common_model->employeePerformanceRecordList();
        return view($this->viewFolderPath . 'employee_performance', ['data' => $data]);
    }
    public function store(Request $request) {
        if(isset($request->employee_performance_comment_row_id))
        {
            $performance_note = \App\Models\HrEmployeePerformanceComments::find($request->employee_performance_comment_row_id);
            $performance_note->employee_row_id = $request->employee_row_id;
            $performance_note->comment_text = $request->comment_text;
            $performance_note->updated_by = Auth()->user()->id;
            $performance_note->save();
            Session::flash('success-message', 'Updated Successfully !');
        }
        else{
            $performance_note = new HrEmployeePerformanceComments();
            $performance_note->employee_row_id = $request->employee_row_id;
            $performance_note->comment_text = $request->comment_text;
            $performance_note->created_by = Auth()->user()->id;
            $performance_note->save();
            Session::flash('success-message', 'Successfully Performed !');
        }
        return Redirect::to('/hr/employee-performance');
    }

    public function deleteRecord($id)
    {
        $performance_note = \App\Models\HrEmployeePerformanceComments::find($id);
        $performance_note->delete();
        Session::flash('success-message', 'Performance record has been removed successfully');    
        return Redirect::to('/hr/employee-performance');
    }

}
