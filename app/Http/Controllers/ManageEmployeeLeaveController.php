<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\HrEmployee;
use App\Models\HrEmployeeDetails;
use App\Models\HrEmployeeHistory;
use App\Models\HrDepartment;
use App\Models\HrDesignation;
use App\Models\HrSalaryHead;
use App\Models\HrEmployeeLeaveRecord;
use \App\Libraries\HrCommon;
use App\Libraries\Common;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use Session;
use DB;
use Config;
use Redirect;
use Carbon\Carbon;
use PDF;
use Excel;
use Illuminate\Support\Facades\Input;

class ManageEmployeeLeaveController extends Controller
{
    private $viewFolderPath = 'hr/';
    public function index()
    {
        $data[] = '';

        $common_model = new HrCommon();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['search_result'] = 0;

        $data['leave_records'] = \App\Models\HrEmployeeLeaveRecord::with('employeeDetails','employeeDepartment', 'employeeDesignation')->get();
        //dd($data['leave_records']);        

        return view($this->viewFolderPath . 'leave_index', ['data' => $data]);
    }
    public function create(Request $request)
    {
        if(isset($request->leave_record_row_id))
        {
            $leave_record = \App\Models\HrEmployeeLeaveRecord::find($request->leave_record_row_id);
            $leave_record->employee_row_id = $request->employee_row_id;
            $leave_record->leave_type = $request->leave_type;
            $leave_record->leave_year = date("Y");
            if($request->is_authorized)
            {
                $leave_record->is_authorized = 1;
            }
            else{
                $leave_record->is_authorized = 0;
            }

            if(isset($request->date_to) && $request->date_to)
            {
                $datetime1 = date_create($request->date_to);
                $datetime2 = date_create($request->date_from);
                $dteDiff  = $datetime1->diff($datetime2);
                $leave_record->number_of_days = $dteDiff->days +1;
                $leave_record->leave_date_to = date('Y-m-d', strtotime($request->date_to));
            }
            else{
                $leave_record->number_of_days = 1;
            }
            $leave_record->leave_date_from = date('Y-m-d', strtotime($request->date_from));
            $leave_record->comment = $request->comment; 
            $leave_record->updated_by = Auth()->user()->id;
            $leave_record->save();
            Session::flash('success-message', 'Leave record has been updated successfully');
        }
        else {
            $leave_record = new HrEmployeeLeaveRecord();
            $leave_record->employee_row_id = $request->employee_row_id;
            $employee = \App\Models\HrEmployee::find($request->employee_row_id);
            $leave_record->leave_type = $request->leave_type;
            $leave_record->leave_year = date("Y");
            if($request->is_authorized)
            {
                $leave_record->is_authorized = 1;
            }
            else{
                $leave_record->is_authorized = 0;
            }

            if(isset($request->date_to) && $request->date_to)
            {
                $datetime1 = date_create($request->date_to);
                $datetime2 = date_create($request->date_from);
                $dteDiff  = $datetime1->diff($datetime2);

                $leave_record->number_of_days = $dteDiff->days +1;
                $leave_record->leave_date_to = date('Y-m-d', strtotime($request->date_to));
            }
            else{
                $leave_record->number_of_days = 1;
            }
            $leave_record->leave_date_from = date('Y-m-d', strtotime($request->date_from));
            $leave_record->comment = $request->comment; 
            $leave_record->created_by = Auth()->user()->id;
            $leave_record->save();
            Session::flash('success-message', 'Leave record has been added successfully'); 
        }
        return redirect('/hr/employee-leave'); 
    }
    public function deleteRecord($leave_record_row_id)
    {
        $leaveRecord = \App\Models\HrEmployeeLeaveRecord::find($leave_record_row_id);
        $leaveRecord->delete();
        Session::flash('success-message', 'Leave record has been removed successfully');    
        return redirect('/hr/employee-leave');
    }
}