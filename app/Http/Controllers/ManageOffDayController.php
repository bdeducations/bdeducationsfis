<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\HrDepartment;
use App\Models\HrDesignation;
use \App\Libraries\HrCommon;
use App\Libraries\Common;
use App\Models\HrOffdaySetting;
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

class ManageOffDayController extends Controller
{
    private $viewFolderPath = 'hr/';
    public function index()
    {
        $data[] = '';

        $common_model = new HrCommon();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['search_result'] = 0;

        $data['offday_list'] = \App\Models\HrOffdaySetting::with('institutionName')->get();
        //dd($data['offday_list']);        

        return view($this->viewFolderPath . 'manage_off_day', ['data' => $data]);
    }
    public function create(Request $request)
    {
        if(isset($request->off_day_row_id))
        {
            $offday = \App\Models\HrOffdaySetting::find($request->off_day_row_id);
            $offday->area_row_id = $request->area_row_id;
            $offday->department_row_id = $request->department_row_id;
            $offday->institution_row_id = $request->institution_row_id;
            $offday->declared_day_name = $request->institutions_offday;
            $offday->updated_by = Auth()->user()->id;
            $offday->save();
            Session::flash('success-message', 'Offday has been updated successfully');   
        }
        else{
            $offday = new HrOffdaySetting();
            $offday->area_row_id = $request->area_row_id;
            $offday->department_row_id = $request->department_row_id;
            $offday->institution_row_id = $request->institution_row_id;
            $offday->declared_day_name = $request->institutions_offday;
            $offday->created_by = Auth()->user()->id;
            $offday->save();
            Session::flash('success-message', 'Offday has been added successfully');
        }
        return redirect('/hr/institution-offday');
    }

    public function delete($off_day_row_id)
    {
        $offdayRecord = \App\Models\HrOffdaySetting::find($off_day_row_id);
        $offdayRecord->delete();
        Session::flash('success-message', 'Offday record has been removed successfully');    
        return redirect('/hr/institution-offday');
    }
}