<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Area;
use App\Models\HrEmployee;
use App\Models\HrEmployeeDetails;
use App\Models\HrEmployeeHistory;
use App\Models\HrDepartment;
use App\Models\HrDesignation;
use App\Models\HrSalaryHead;
use App\Models\HrInstitution;
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
use Zipper;
use Response;

class ManageEmployeeController extends Controller
{
    private $viewFolderPath = 'hr/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct() {
         $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $data[] = '';
        $data['selected_area_row_id'] = '';
        $data['search_result'] = 0;
        $common_model = new HrCommon();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['department_row_id'] = '';
        return view($this->viewFolderPath . 'employee_list', ['data' => $data]);
    }

    public function search(Request $request){
        $common_model = new HrCommon();
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->orderBy('sort_order')->get();
        $data['search_result'] = 0;
        $data['list_all'] = 0;        
        $data['department_row_id'] = $request->department_row_id;

        if ($data['department_row_id'] > 0) {
            $data['employee_list'] = $common_model->employeeList($data['department_row_id']);
        }
        else{
            // $data['employee_list'] = DB::table('hr_employees')->join('hr_departments', 'hr_employees.department_row_id', '=', 'hr_departments.department_row_id')->select('hr_employees.*', 'hr_departments.department_name')->join('hr_designations', 'hr_employees.designation_row_id', '=', 'hr_designations.designation_row_id')->select('hr_employees.*', 'hr_designations.designation_name')->orderBy('hr_departments.sort_order', 'asc')->orderBy('hr_designations.sort_order', 'asc')->get();
        
            $data['employee_list'] = \App\Models\HrEmployee::with('employeeDetails','employeeDepartment', 'employeeDesignation')                          
                            ->get()->sortBy(function($q) {
                            return $q->employeeDesignation->sort_order;
                        });        
        

            $data['list_all'] = 1;
        }
        
        if($data['employee_list']){
           $data['search_result'] = 1; 
        }
        return view($this->viewFolderPath . 'employee_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['blood_group'] = config('site_config.blood_group');
        $data['religion'] = config('site_config.religion');
        $data['divisionlist'] = config('site_config.divisionlist');
        $data['relationship'] = config('site_config.next_kin_relationship'); 
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['grad_exam_name'] = \App\Models\HrGrad_exam_name::get();
        $data['grad_postgrad_subject_name'] = \App\Models\HrGrad_postgrad_subject_name::get();
        $data['post_grad_exam_name'] = \App\Models\HrPost_grad_exam_name::get();
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);
        //dd( $grad_exam_name);
        return view('hr.employee_create',['data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = new HrEmployee;    
        $employeeDetails = new HrEmployeeDetails;    
        $employeeHistory = new HrEmployeeHistory;   
        $common = new Common;  

        $employee->area_row_id = $request->area_row_id;
        $employee->employee_name = $request->employee_name;
        $employee->employee_name_bangla = $request->employee_name_bangla ;
        $employee->employee_email = $request->employee_email;
        $employee->created_by = Auth()->user()->id;
        $employee->contact_1 = $request->contact_1;
        $employee->contact_2 = $request->contact_2;
        $employee->gender = $request->gender; 
        $employee->blood_group = $request->blood_group;
        $employee->joining_date = $request->joining_date;
        if(isset($request->password ))
        {        
          $employee->plain_password = $request->password;
          $employee->password = Hash::make($request->password);                
        }
        $employee->department_row_id = $request->departments;
        $employee->institution_row_id = $request->institutions;
        $employee->designation_row_id = $request->designation_row_id;           
        
        $employeeDetails->nid = $request->nid;
        $employeeDetails->religion = $request->religion;
        $employeeDetails->nationality = $request->nationality;     
        $employeeDetails->dob = $request->dob;
        $employeeDetails->next_of_kin = $request->next_of_kin;
        $employeeDetails->kin_relationship = $request->kin_relationship; 

        $employeeDetails->present_address = $request->present_address;
        $employeeDetails->present_address_bangla = $request->present_address_bangla;       
        $employeeDetails->present_division_id = $request->division_present;
        $employeeDetails->present_district_id = $request->district_present;
        $employeeDetails->present_upazila_id = $request->upazila_present;
        $employeeDetails->present_post_code = $request->postcode_present;
        $employeeDetails->permanent_address = $request->permanent_address;
        $employeeDetails->permanent_address_bangla = $request->permanent_address_bangla;
        $employeeDetails->permanent_division_id = $request->division_permanent;
        $employeeDetails->permanent_district_id = $request->district_permanent;
        $employeeDetails->permanent_upazila_id = $request->upazila_permanent;
        $employeeDetails->permanent_post_code = $request->postcode_permanent;
        
        $employeeDetails->ssc_exam_name = $request->ssc_exam_name;
        $employeeDetails->ssc_group = $request->ssc_group;
        $employeeDetails->ssc_result = $request->ssc_result;
        $employeeDetails->ssc_board = $request->ssc_board;
        $employeeDetails->ssc_passing_year = $request->ssc_passing_year;
     
        $employeeDetails->hsc_exam_name = $request->hsc_exam_name;
        $employeeDetails->hsc_group = $request->hsc_group;
        $employeeDetails->hsc_result = $request->hsc_result;
        $employeeDetails->hsc_board = $request->hsc_board;
        $employeeDetails->hsc_passing_year = $request->hsc_passing_year;
        
        $employeeDetails->graduation_exam_row_id = $request->graduation_exam_row_id;
        $employeeDetails->graduation_subject_row_id = $request->graduation_subject_row_id;
        $employeeDetails->graduation_result = $request->graduation_result;
        $employeeDetails->graduation_board = $request->graduation_board;
        $employeeDetails->graduation_passing_year = $request->graduation_passing_year;
        
        $employeeDetails->post_graduation_exam_row_id = $request->post_graduation_exam_row_id;
        $employeeDetails->post_graduation_subject_row_id= $request->post_graduation_subject_row_id;
        $employeeDetails->post_graduation_result = $request->post_graduation_result;
        $employeeDetails->post_graduation_board = $request->post_graduation_board;
        $employeeDetails->post_graduation_passing_year = $request->post_graduation_passing_year;

        $employeeDetails->higher_degree_exam_name = $request->higher_degree_exam_name;
        $employeeDetails->higher_degree_subject_row_id = $request->higher_degree_subject_row_id;
        $employeeDetails->higher_degree_result = $request->higher_degree_result;
        $employeeDetails->higher_degree_board = $request->higher_degree_board;
        $employeeDetails->higher_degree_passing_year = $request->higher_degree_passing_year;
            
        $employeeDetails->special_training = $request->special_training;  

        $employeeHistory->department_row_id = $request->departments;  
        $employeeHistory->designation_row_id = $request->designation_row_id;
        $employeeHistory->salary_effected_from = $request->salary_effected_from;
        $employeeHistory->created_at = getCurrentDateTimeForDB();
        $employeeHistory->created_by = Auth()->user()->id;

        DB::beginTransaction(); 
        try 
        {
            $employee->save();                     
            $employeeDetails->employee_row_id = $employee->employee_row_id; 
                
            $employee->photo_name = $common->uploadImage('employee_image', 'images/employee/'.$employee->employee_row_id. '/', $employee->employee_name. '_' . time(), 1 );
            
            $employee->signature_image_name = $common->uploadImage('signature_image', 'images/employee/'.$employee->employee_row_id. '/','signature'.$employee->employee_name. '_'.time() ); 

            $employeeDetails->nid_photo = $common->uploadImage('national_id_photo', 'images/employee/'.$employee->employee_row_id. '/', $employee->employee_name .time()); 

            $employeeDetails->ssc_certificate_photo = $common->uploadImage('ssc_certificate_image', 'images/employee/'.$employee->employee_row_id. '/', $employee->ssc_exam_name .time(), 1 );

            $employeeDetails->hsc_certificate_photo = $common->uploadImage('hsc_certificate_image', 'images/employee/'.$employee->employee_row_id. '/', $employee->hsc_exam_name .time(), 1 );
            
            $employeeDetails->graduation_certificate_photo = $common->uploadImage('graduation_certificate_image', 'images/employee/'.$employee->employee_row_id. '/',$employee->graduation_exam_name .time(), 1 );
            $employeeDetails->post_graduation_certificate_photo = $common->uploadImage('post_graduation_certificate_image', 'images/employee/'.$employee->employee_row_id. '/',$employee->post_graduation_exam_name .time(), 1 );
            $employeeDetails->higher_degree_certificate_photo = $common->uploadImage('higher_degree_certificate_image', 'images/employee/'.$employee->employee_row_id. '/',$employee->higher_degree_exam_name .time(), 1 );

            $employeeHistory->employee_row_id = $employee->employee_row_id; 
            $employee->save();         
            $employeeDetails->save(); 
            $employeeHistory->save();  
        }
        catch ( Exception $e ) 
        {    
            DB::rollback();
        }
        DB::commit();
        
        
        Session::flash('success-message', 'Member has been added successfully');    
        return redirect('/manage-employee'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data[] = '';
        $data['blood_group'] = config('site_config.blood_group');
        $data['religion'] = config('site_config.religion');
        $data['divisionlist'] = config('site_config.divisionlist');
        $data['relationship'] = config('site_config.next_kin_relationship'); 
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['grad_exam_name'] = \App\Models\HrGrad_exam_name::get();
        $data['grad_postgrad_subject_name'] = \App\Models\HrGrad_postgrad_subject_name::get();
        $data['post_grad_exam_name'] = \App\Models\HrPost_grad_exam_name::get();
        $common_model = new Common();
        $data['all_areas'] = $common_model->allAreas(1);

        $hrObj = new HrCommon();
        $data['employee_info'] =   $hrObj->singleEmployeeInfo($id); 
        // dd($data['employee_info']);
        return view($this->viewFolderPath . 'employee_edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = new HrEmployee;    
        $employeeDetails = new HrEmployeeDetails;    
        $employeeHistory = new HrEmployeeHistory;   
        $common = new Common;  
        
        
        $employee = \App\Models\HrEmployee::find($id);
        //Admin Modle input     
        $employee->area_row_id = $request->area_row_id;
        $employee->employee_name = $request->employee_name;
        $employee->employee_name_bangla = $request->employee_name_bangla ;
        $employee->employee_email = $request->employee_email;
        $employee->created_by = Auth()->user()->id;
        
        if($request->employee_image){
            $employee->photo_name = $common->uploadImage('employee_image', 'images/employee/'.$id. '/', $employee->employee_name. '_' . time(), 1 );
        }  
        if($request->signature_image){
           $employee->signature_image_name = $common->uploadImage('signature_image', 'images/employee/'.$id. '/','signature'.$employee->employee_name. '_'.time() ); 
        }

        $employee->contact_1 = $request->contact_1;
        $employee->contact_2 = $request->contact_2;
        $employee->gender = $request->gender; 
        $employee->blood_group = $request->blood_group;
        $employee->joining_date = $request->joining_date;
        
        if(isset($request->password ))
        {        
          $employee->plain_password = $request->password;
          $employee->password = Hash::make($request->password);                
        }
        $employee->institution_row_id = $request->institutions;
        $employee->department_row_id = $request->departments;  
        $employee->designation_row_id = $request->designation_row_id;
        
        $employeeDetails = \App\Models\HrEmployeeDetails::where('employee_row_id', $id)->first(); 
        $employeeDetails->nid = $request->nid;
        if($request->national_id_photo){
            $employeeDetails->nid_photo = $common->uploadImage('national_id_photo', 'images/employee/'.$id. '/', $employee->employee_name .time()); 
        }
        $employeeDetails->next_of_kin = $request->next_of_kin;
        $employeeDetails->kin_relationship = $request->kin_relationship;     
        $employeeDetails->dob = $request->dob;
        $employeeDetails->present_address = $request->present_address;
        $employeeDetails->present_address_bangla = $request->present_address_bangla;       
        $employeeDetails->present_division_id = $request->division_present;
        $employeeDetails->present_district_id = $request->district_present;
        $employeeDetails->present_upazila_id = $request->upazila_present;
        $employeeDetails->present_post_code = $request->postcode_present;
        
        $employeeDetails->permanent_address = $request->permanent_address;
        $employeeDetails->permanent_address_bangla = $request->permanent_address_bangla;
        $employeeDetails->permanent_division_id = $request->division_permanent;
        $employeeDetails->permanent_district_id = $request->district_permanent;
        $employeeDetails->permanent_upazila_id = $request->upazila_permanent;
        $employeeDetails->permanent_post_code = $request->postcode_permanent;
        
        $employeeDetails->ssc_exam_name = $request->ssc_exam_name;
        $employeeDetails->ssc_group = $request->ssc_group;
        $employeeDetails->ssc_result = $request->ssc_result;
        $employeeDetails->ssc_board = $request->ssc_board;
        $employeeDetails->ssc_passing_year = $request->ssc_passing_year;
        
        $employeeDetails->hsc_exam_name = $request->hsc_exam_name;
        $employeeDetails->hsc_group = $request->hsc_group;
        $employeeDetails->hsc_result = $request->hsc_result;
        $employeeDetails->hsc_board = $request->hsc_board;
        $employeeDetails->hsc_passing_year = $request->hsc_passing_year;
        
        $employeeDetails->graduation_exam_row_id = $request->graduation_exam_row_id;
        $employeeDetails->graduation_subject_row_id = $request->graduation_subject_row_id;
        $employeeDetails->graduation_result = $request->graduation_result;
        $employeeDetails->graduation_board = $request->graduation_board;
        $employeeDetails->graduation_passing_year = $request->graduation_passing_year;
        
        $employeeDetails->post_graduation_exam_row_id = $request->post_graduation_exam_row_id;
        $employeeDetails->post_graduation_subject_row_id= $request->post_graduation_subject_row_id;
        $employeeDetails->post_graduation_result = $request->post_graduation_result;
        $employeeDetails->post_graduation_board = $request->post_graduation_board;
        $employeeDetails->post_graduation_passing_year = $request->post_graduation_passing_year;
        
        $employeeDetails->higher_degree_exam_name = $request->higher_degree_exam_name;
        $employeeDetails->higher_degree_subject_row_id = $request->higher_degree_subject_row_id;
        $employeeDetails->higher_degree_result = $request->higher_degree_result;
        $employeeDetails->higher_degree_board = $request->higher_degree_board;
        $employeeDetails->higher_degree_passing_year = $request->higher_degree_passing_year;
        
        if($request->ssc_certificate_image){
            $employeeDetails->ssc_certificate_photo = $common->uploadImage('ssc_certificate_image', 'images/employee/'.$id. '/', $employee->ssc_exam_name .time(), 1 );    
        }
        
        if($request->hsc_certificate_image){
            $employeeDetails->hsc_certificate_photo = $common->uploadImage('hsc_certificate_image', 'images/employee/'.$id. '/', $employee->hsc_exam_name .time(), 1 );
        }
        
        if($request->graduation_certificate_image){
            $employeeDetails->graduation_certificate_photo = $common->uploadImage('graduation_certificate_image', 'images/employee/'.$id. '/',$employee->graduation_exam_name .time(), 1 );
        }
        if($request->post_graduation_certificate_image){
            $employeeDetails->post_graduation_certificate_photo = $common->uploadImage('post_graduation_certificate_image', 'images/employee/'.$id. '/',$employee->post_graduation_exam_name .time(), 1 );
        }
        if($request->higher_degree_certificate_image){
            $employeeDetails->higher_degree_certificate_photo = $common->uploadImage('higher_degree_certificate_image', 'images/employee/'.$id. '/',$employee->higher_degree_exam_name .time(), 1 );
        }
        
            
        $employeeDetails->special_training = $request->special_training;  

        $employeeHistory= \App\Models\HrEmployeeHistory::where('employee_row_id', $id)->first(); 

        $employeeHistory->department_row_id = $request->departments;  
        $employeeHistory->designation_row_id = $request->designation_row_id;
        $employeeHistory->created_by = Auth()->user()->id;
        
        DB::beginTransaction(); 
        try 
        {
            $employee->save();                             
            $employeeDetails->save(); 
            $employeeHistory->save();    
        }
        catch ( Exception $e ) 
        {    
            DB::rollback();
        }
        DB::commit();
        
        Session::flash('success-message', 'Employee information has been updated successfully');
         return redirect('/manage-employee'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function employeeDetailsPdf($id)
    {
        $viewFolderPath = 'hr/';
        $data['employeeInfo'] = \App\Models\HrEmployee::with('areaName','employeeInstitution','employeeDetails','employeeDepartment','employeeDesignation')->where('employee_row_id',$id)->first();
        $employee_info = $data['employeeInfo']->toArray();
        //dd($employee_info);
        if($employee_info['photo_name'] != '') {
            $imageurl = url('/').'/public/images/employee/'.$data['employeeInfo']->employee_row_id.'/'.$employee_info['photo_name'];
        } else {
            $imageurl = url('/').'/public/images/employee/default_employee_photo.png';
        }
        $data['imageurl'] = $imageurl;
        //dd($data['imageurl']);


        $grad_exam_name = '';
        $grad_info_row = '';

        if($employee_info['employee_details']['graduation_exam_row_id']) 
        {
        
        $grad_exam_name =\App\Models\HrGrad_exam_name::where('grad_exam_row_id', $employee_info['employee_details']['graduation_exam_row_id'])->first()->grad_exam_name;

        $grad_subject_name = '';
        if($employee_info['employee_details']['graduation_subject_row_id'])
        {
            $grad_subject_name = \App\Models\HrGrad_postgrad_subject_name::where('grad_postgrad_subject_name_row_id', $employee_info['employee_details']['graduation_subject_row_id'])->first()->subject_title;
        }

        $grad_info_row = '  <tr>
                                <td>'.$grad_exam_name.'</td>
                                <td>'.$grad_subject_name.'</td>
                                <td>'.$employee_info['employee_details']['graduation_result'].'</td>
                                <td>'.$employee_info['employee_details']['graduation_board'].'</td>
                                <td>'.$employee_info['employee_details']['graduation_passing_year'].'</td>
                            </tr>'; 
        }

        $data['grad_info_row'] = $grad_info_row;

        $post_grad_exam_name = '';
        $post_grad_info_row = '';
        if($employee_info['employee_details']['post_graduation_exam_row_id']) 
        {
            $post_grad_exam_name =\App\Models\HrPost_grad_exam_name::where('post_grad_exam_row_id', $employee_info['employee_details']['post_graduation_exam_row_id'])->first()->post_grad_exam_name;

            $post_grad_subject_name = '';
            if($employee_info['employee_details']['post_graduation_subject_row_id'])
            {
                $post_grad_subject_name = \App\Models\HrGrad_postgrad_subject_name::where('grad_postgrad_subject_name_row_id', $employee_info['employee_details']['post_graduation_subject_row_id'])->first()->subject_title;
            }

            $post_grad_info_row = '<tr>
                                        <td>'.$post_grad_exam_name.'</td>
                                        <td>'.$post_grad_subject_name.'</td>
                                        <td>'.$employee_info['employee_details']['post_graduation_result'].'</td>
                                        <td>'.$employee_info['employee_details']['post_graduation_board'].'</td>
                                        <td>'.$employee_info['employee_details']['post_graduation_passing_year'].'</td>
                                    </tr>';
        }
        $data['post_grad_info_row'] = $post_grad_info_row;

        $higher_degree_exam_name = '';
        $higher_education_info_row = '';

        
        if($employee_info['employee_details']['higher_degree_exam_name'] && $employee_info['employee_details']['higher_degree_subject_row_id']) 
        {

            $higher_degree_subject_name = '';
            if($employee_info['employee_details']['higher_degree_subject_row_id'])
            {
                $higher_degree_subject_name = \App\Models\HrGrad_postgrad_subject_name::where('grad_postgrad_subject_name_row_id', $employee_info['employee_details']['higher_degree_subject_row_id'])->first()->subject_title;
            }

            $higher_education_info_row = '<tr>
                                        <td>'.$employee_info['employee_details']['higher_degree_exam_name'].'</td>
                                        <td>'.$higher_degree_subject_name.'</td>
                                        <td>'.$employee_info['employee_details']['higher_degree_result'].'</td>
                                        <td>'.$employee_info['employee_details']['higher_degree_board'].'</td>
                                        <td>'.$employee_info['employee_details']['higher_degree_passing_year'].'</td>
                                    </tr>';
        }

        $data['higher_education_info_row'] = $higher_education_info_row;

        $data['dateofbirth'] = ($employee_info['employee_details']['dob'] != '0000-00-00') ? $employee_info['employee_details']['dob'] : ' - ';
        $bloodgroup = config('site_config.blood_group');
        $data['bloodgroup'] = $bloodgroup[$employee_info['blood_group']];
        $religion = config('site_config.religion');
        $data['religion'] = $religion[$employee_info['employee_details']['religion']];
        if($employee_info['employee_details']['present_division_id'] != 0) {
            $presentdivision = config('site_config.divisionlist');
            $presentdivision = $presentdivision[$employee_info['employee_details']['present_division_id']];
        } else {
            $presentdivision = '';
        }
        
        $data['presentdivision'] = $presentdivision;

        $next_kin_config = config('site_config.next_kin_relationship'); 
        $data['next_kin_relationship'] = $next_kin_config[$employee_info['employee_details']['kin_relationship']];

        $data['presentdistrict'] = DB::table('districts')->where('id', $employee_info['employee_details']['present_district_id'])->value('full_name');
        $data['presentupazila'] = DB::table('upazila')->where('id', $employee_info['employee_details']['present_upazila_id'])->value('full_name');
        $data['presentpostcode'] = ($employee_info['employee_details']['present_post_code'] != 0) ? $employee_info['employee_details']['present_post_code'] : ' - ';
        
        if($employee_info['employee_details']['permanent_division_id'] != 0) {
            $permanentdivision = config('site_config.divisionlist');
            $permanentdivision = $permanentdivision[$employee_info['employee_details']['permanent_division_id']];
        } else {
            $permanentdivision = '';
        }
        $data['permanentdivision'] = $permanentdivision;
        
        $data['permanentdistrict'] = DB::table('districts')->where('id', $employee_info['employee_details']['permanent_district_id'])->value('full_name');
        $data['permanentupazila'] = DB::table('upazila')->where('id', $employee_info['employee_details']['permanent_upazila_id'])->value('full_name');
        $data['permanentpostcode'] = ($employee_info['employee_details']['permanent_post_code'] != 0) ? $employee_info['employee_details']['permanent_post_code'] : ' - ';
        
        

             
        if($employee_info['contact_1'] && $employee_info['contact_2'] )
        {
            $contact = $employee_info['contact_1'] . ',' . $employee_info['contact_2'];

        }
        else if($employee_info['contact_1'] && !$employee_info['contact_2'] )
        {
            $contact = $employee_info['contact_1'];

        } else if(!$employee_info['contact_1'] && $employee_info['contact_2'] )
        {
            $contact = $employee_info['contact_2'];

        } 
        else
        {
            $contact = '';

        }       

        $data['contact'] = trim($contact, ',');



        $pdf = PDF::loadView($viewFolderPath .  'staff_pdf', ['data'=>$data]);                  
        return $pdf->stream( 'Employee' . '.pdf');
    }

    /*  Department, Designation  */

    public function departments(Request $request) {
       
        if ($request->isMethod('post')) {
            if(isset($request->department_row_id))
            {
                $department = \App\Models\HrDepartment::find($request->department_row_id);
                $department->department_name = $request->department_name;  
                $department->sort_order = $request->sort_order;
                $department->updated_by = Auth()->user()->id;
                $department->save();
                Session::flash('success-message', 'Department has been Updated successfully');
                return redirect('/hr/manage-departments');
            }
            else{
                $department = new HrDepartment();
                $department->department_name = $request->department_name;
                $department->sort_order = $request->sort_order;
                $department->created_by = Auth()->user()->id;

                $department->save();
                Session::flash('success-message', 'Department has been added successfully');
                return redirect('/hr/manage-departments');
            }
            
        }
        else{
            $hrObj = new HrCommon();
            $data['departments_list'] = $hrObj->departments();
            return view($this->viewFolderPath . 'departments_list', ['data' => $data]);
        }
        

    }

    public function deleteDepartment($department_row_id){
        $deleteDepartment =\App\Models\HrDepartment::where('department_row_id',$department_row_id)->delete();
        Session::flash('success-message', 'Department has been deleted successfully');
        return redirect('/hr/manage-departments');
    }

    public function designations(Request $request) {
        if ($request->isMethod('post')) {
            if(isset($request->designation_row_id))
            {
                $designation = \App\Models\HrDesignation::find($request->designation_row_id);
                $designation->department_row_id = $request->department_row_id;
                $designation->designation_name = $request->designation_name;
                $designation->sort_order = $request->sort_order;
                $designation->updated_by = Auth()->user()->id;  
              
                $designation->save();
                Session::flash('success-message', 'Designation has been Updated successfully');
                return redirect('/hr/manage-designations');
            }
            else{
                $designation = new HrDesignation();
                $designation->department_row_id =  $request->department_row_id;
                $designation->designation_name = $request->designation_name;
                $designation->sort_order = $request->sort_order;
                $designation->created_by = Auth()->user()->id;

                $designation->save();
                Session::flash('success-message', 'Designation has been added successfully');
                return redirect('/hr/manage-designations');
            }
        }
        else{
            $hrObj = new HrCommon();
            $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
            $data['designations_list'] = $hrObj->designations();
            // dd($data['designations_list']);
            return view($this->viewFolderPath . 'designations_list', ['data' => $data]);
        }
    }
    public function deleteDesignation($designation_row_id){
        $deleteDesignation=\App\Models\HrDesignation::where('designation_row_id',$designation_row_id)->delete();
        Session::flash('success-message', 'Designation has been deleted successfully');
        return redirect('/hr/manage-designations');
    }

    public function salaryHeads(Request $request) {
        if ($request->isMethod('post')) {
            if(isset($request->salary_head_row_id))
            {
                $head = \App\Models\HrSalaryHead::find($request->salary_head_row_id);
                $head->salary_head_name = $request->salary_head_name;  
                $head->sort_order = $request->sort_order;
                $salary_head_slug_without_space = str_replace(' ', '_', $request->salary_head_name);
                $salary_head_slug_in_lowercase = Str::lower($salary_head_slug_without_space);
                
                $salary_head_slug_flag = \App\Models\HrSalaryHead::where('salary_head_slug', '=', $salary_head_slug_in_lowercase)->first();
                if ($salary_head_slug_flag === null) {
                   $head->salary_head_slug = $salary_head_slug_in_lowercase;
                    $head->updated_by = Auth()->user()->id;
                    $head->save();
                    Session::flash('success-message', 'Head has been Updated successfully');
                    return redirect('/hr/salary-heads');
                }
                else{
                   Session::flash('error-message', 'Head Already Exist');
                   return redirect('/hr/salary-heads');
                }
            }
            else{
                $head = new HrSalaryHead();
                $head->salary_head_name = $request->salary_head_name;
                $head->sort_order = $request->sort_order;
                $salary_head_slug_without_space = str_replace(' ', '_', $request->salary_head_name);
                $salary_head_slug_in_lowercase = Str::lower($salary_head_slug_without_space);
                
                $salary_head_slug_flag = \App\Models\HrSalaryHead::where('salary_head_slug', '=', $salary_head_slug_in_lowercase)->first();

                if ($salary_head_slug_flag === null) {
                   $head->salary_head_slug = $salary_head_slug_in_lowercase;
                   $head->created_by = Auth()->user()->id;
                   $head->save();
                   Session::flash('success-message', 'Head has been added successfully');
                   return redirect('/hr/salary-heads');
                }
                else{
                   Session::flash('error-message', 'Head Already Exist');
                   return redirect('/hr/salary-heads');
                }
            }
        }
        else{
            $hrObj = new HrCommon();
            $data['salary_heads'] = \App\Models\HrSalaryHead::orderBy('sort_order')->get();
            return view($this->viewFolderPath . 'salary_heads_list', ['data' => $data]);
        }
    }

    public function deleteSalaryHeads($salary_head_row_id){
        $deleteHead=\App\Models\HrSalaryHead::where('salary_head_row_id',$salary_head_row_id)->delete();
        Session::flash('success-message', 'Head has been deleted successfully');
        return redirect('/hr/salary-heads');
    }

    /*  Set amount to slary heads */
    public function salaryHeadsPaySettings() {
        $hrObj = new HrCommon();        
        $data['head_wise_payments'] = $hrObj->setSalaryHeadsPaySettings(); 
       // dd($data['head_wise_payments'] );
             
        return view($this->viewFolderPath . 'salary_heads_pay_setting', ['data' => $data]);
    }

    public function getSalaryHeadAmount($basic_salary) {
            $hrObj = new HrCommon();        
            $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings();

            foreach ($data['head_wise_payments'] as $key => $value) {
                $newKey = $value->salary_head_row_id;
                
                if($value->percantage_fixed == 1) {
                    $arr[$newKey] = ($basic_salary * $value->amount_percantage)/100;
                } else {
                    $arr[$newKey] = $value->amount_fixed ? $value->amount_fixed : 0;
                }
            }
            echo json_encode($arr);
    }

    /* get current salary called from ajax.*/

    public function getEmployeeStartingSalary($employee_row_id) {
            $hrObj = new HrCommon();        
            $salary=[];

            $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings();
            $salaryInfo = $hrObj->getEmployeeStartingSalary($employee_row_id);
            if(count($salaryInfo)){
                $salary = json_decode($salaryInfo->salary_parts, true);
                $salary['basic_salary'] = $salaryInfo->basic_salary;
                $salary['gross_salary'] = $salaryInfo->gross_salary;
            }
            echo json_encode($salary);  //json array
    }

    
    /* 
    All employee list with the option to set salary, increament etc.
    */
    public function employeeListForPayroll(Request $request) {
        $hrObj = new HrCommon();
        $salary_heads = \App\Models\HrSalaryHead::orderBy('sort_order')->get();

        $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings(); 
        $hrEmployeeHistoryObj = new \App\Models\HrEmployeeHistory();
        $head_amount_arr = [];

        // If salry Form, increament form, promotion form is submitetd submitted then do following      
       
        if($request->isMethod('post')) {

            // add/update current salary
            if($request->set_salary) {
                $head_amount_arr = [];
                $hrEmployeeHistoryObj->basic_salary = $request->basic_salary;
                $hrEmployeeHistoryObj->employee_row_id = $request->employee_row_id;
                foreach ($salary_heads as $row) {
                    $salary_head_slug =  $row->salary_head_slug;
                    $head_amount_arr[$row->salary_head_row_id] = $request->$salary_head_slug;
                }
                $hrEmployeeHistoryObj->salary_parts = json_encode($head_amount_arr);
                $hrEmployeeHistoryObj->gross_salary = $request->basic_salary + array_sum($head_amount_arr);
                $hrEmployeeHistoryObj->save();
            }
        }
        
        $data['employee_list'] = $hrObj->employeeList();
        $data['designations_list'] = $hrObj->designations();
        $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings();
        return view($this->viewFolderPath . 'employee_list_payroll', ['data' => $data]);
    }
	
	public function employeeSalarySettings(Request $request, $employee_row_id) {

		$hrObj = new HrCommon();
        $hrEmployeeHistoryObj = new \App\Models\HrEmployeeHistory();
        $salary_heads = \App\Models\HrSalaryHead::orderBy('sort_order')->get();
        $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings();
        $data['employee_list'] = $hrObj->employeeList();
        $data['departments'] = $hrObj->departments();
        $data['designations_list'] = $hrObj->designations();
        

        $head_amount_arr = [];
        if($request->isMethod('post')) {

            // add/update current salary
            /* 
                 When employee is created first, then entry goes to employee_history table.
             */
            if($request->set_salary) {
                $head_amount_arr = [];
                // when employee is created then entry goes to emplyee history table with designation, department
                $employee_history_row_id = \App\Models\HrEmployeeHistory::where('employee_row_id', $request->employee_row_id)->first()->employee_history_row_id;
                $hrEmployeeHistoryObj = \App\Models\HrEmployeeHistory::find($employee_history_row_id);

                $hrEmployeeHistoryObj->basic_salary = $request->basic_salary;
                $hrEmployeeHistoryObj->employee_row_id = $request->employee_row_id;
                foreach ($salary_heads as $row) {
                    $salary_head_slug =  $row->salary_head_slug;
                    $head_amount_arr[$row->salary_head_row_id] = $request->$salary_head_slug;
                }
                $hrEmployeeHistoryObj->salary_parts = json_encode($head_amount_arr);
                $hrEmployeeHistoryObj->gross_salary = $request->basic_salary + array_sum($head_amount_arr);
                $hrEmployeeHistoryObj->is_starting_salary = 1;
                $hrEmployeeHistoryObj->salary_effected_from = $request->salary_effected_from;
                $hrEmployeeHistoryObj->salary_year =  date('Y');
               
                $hrEmployeeHistoryObj->updated_at = getCurrentDateTimeForDB();
                $hrEmployeeHistoryObj->updated_by =  Auth()->user()->id;
                $hrEmployeeHistoryObj->save();
            }

        }

          //employee info
        $data['employee_info'] = $hrObj->singleEmployeeInfo($employee_row_id);        

         // Get Starting  salary
        $data['employee_row_id'] = $employee_row_id;              
        $data['salary_parts'] = [];
        $data['basic_salary'] = 0;
        $data['gross_salary'] = 0;
        $data['salary_effected_from'] = '';
        $salaryInfo = $hrObj->getEmployeeStartingSalary($employee_row_id);
        if(count($salaryInfo)){
            $data['salary_parts'] = json_decode($salaryInfo->salary_parts, true);
            $data['basic_salary'] = $salaryInfo->basic_salary;
            $data['gross_salary'] = $salaryInfo->gross_salary;
           $data['salary_effected_from'] = $salaryInfo->salary_effected_from;
           
        }
        /* end of Starting salary */


        // Get Current  salary, used to only show in Tab 3               
        $data['current_salary_parts'] = [];
        $data['current_basic_salary'] = 0;
        $data['current_gross_salary'] = 0;       
        $currentSalaryInfo = $hrObj->getEmployeeCurrentSalary($employee_row_id);
        if(count($salaryInfo)){
            $data['current_salary_parts'] = json_decode($currentSalaryInfo->salary_parts, true);
            $data['current_basic_salary'] = $currentSalaryInfo->basic_salary;
            $data['current_gross_salary'] = $currentSalaryInfo->gross_salary; 
        }
        
        // get all salary recrods including starting salary to last increament, to show in increament section.
        $data['all_salary_records'] = $hrObj->getAllSalaryRecords($employee_row_id);
        
        // get performance note of this employee.
        $data['performance_comments'] = $hrObj->getEmployeePerformanceComments($employee_row_id);

		
        return view($this->viewFolderPath . 'employee_salary_setting', ['data' => $data]);
		
	}

    public function saveIncreament(Request $request, $employee_row_id) { 
        $data['employee_row_id'] = $employee_row_id;  
        
        $hrObj = new HrCommon();
        $hrEmployeeHistoryObj = new \App\Models\HrEmployeeHistory();
        
        // get salary heads and head wise payment 
        $salary_heads = \App\Models\HrSalaryHead::orderBy('sort_order')->get();
        $data['head_wise_payments'] = $hrObj->getSalaryHeadsPaySettings();

        // while increament, department and designcation can be changed so, update  hr_employees
        // current department and designation.        
        $employee = new HrEmployee;
        $employee = \App\Models\HrEmployee::find($employee_row_id);        
        $employee->department_row_id = $request->department_row_id;
        $employee->designation_row_id = $request->designation_row_id;       
        $employee->save();
        //... done update hr_employees table

        /* get current salary */           
        $data['salary_parts'] = [];
        $data['basic_salary'] = 0;
        $data['gross_salary'] = 0;
        $salaryInfo = $hrObj->getEmployeeCurrentSalary($employee_row_id);
        if(count($salaryInfo)){
        $data['salary_parts'] = json_decode($salaryInfo->salary_parts, true);
        $data['basic_salary'] = $salaryInfo->basic_salary;
        $data['gross_salary'] = $salaryInfo->gross_salary;
        }

        /* Insert New record in employee history table, increamented salary info.  */
        $head_amount_arr = [];
        $hrEmployeeHistoryObj->department_row_id =  $request->department_row_id;
        $hrEmployeeHistoryObj->designation_row_id =  $request->designation_row_id;
        $hrEmployeeHistoryObj->increamented_basic_salary = $request->basic_salary;
        $hrEmployeeHistoryObj->basic_salary = $salaryInfo->basic_salary + $request->basic_salary;

        $hrEmployeeHistoryObj->employee_row_id = $employee_row_id;
        foreach ($salary_heads as $row) {
            $salary_head_slug =  $row->salary_head_slug;
            $head_amount_arr[$row->salary_head_row_id] = $request->$salary_head_slug;
        }
        $current_salary_parts = json_decode($salaryInfo->salary_parts, true);               
        $salary_parts_arr = array_merge($current_salary_parts,  $head_amount_arr);
        
        $hrEmployeeHistoryObj->salary_parts = json_encode($salary_parts_arr);
        $hrEmployeeHistoryObj->gross_salary = $hrEmployeeHistoryObj->basic_salary + array_sum($salary_parts_arr);

        $hrEmployeeHistoryObj->increamented_salary_parts = json_encode($head_amount_arr);
        $hrEmployeeHistoryObj->increamented_gross_salary = $hrEmployeeHistoryObj->increamented_basic_salary + array_sum($head_amount_arr);

        $hrEmployeeHistoryObj->is_starting_salary = 0;
        $hrEmployeeHistoryObj->salary_effected_from = $request->increament_effected_from;
        $hrEmployeeHistoryObj->salary_year =  date('Y');
        
        $hrEmployeeHistoryObj->created_at = getCurrentDateTimeForDB();
        $hrEmployeeHistoryObj->created_by = Auth::user()->id;        
        $hrEmployeeHistoryObj->save();
        Session::flash('success-message', 'Successfully Performed !');

        return redirect('/hr/employee-salary-settings/' . $employee_row_id);


    }
    public function salarySheet() {
        $hrObj = new HrCommon();
        $data['areas'] = \App\Models\Area::get();
        $data['departments_list'] = $hrObj->departments();
        $data['designations_list'] = $hrObj->designations();
        return view($this->viewFolderPath . 'salary_sheet', ['data' => $data]);
    }

    public function salarySheetViewWithLeaveRecord(Request $request) {
        $hrObj = new HrCommon();
        $are_row_id = $request->area_row_id;
        $department_row_id = $request->department_row_id;
        $salary_year = $request->salary_year;
        $salary_month = $request->salary_month;

        if($are_row_id == 'all') {

        }

        $data['areas'] = \App\Models\Area::get();
        $data['departments_list'] = $hrObj->departments();
        $data['designations_list'] = $hrObj->designations();
        return view($this->viewFolderPath . 'salary_sheet_view_with_leave_record', ['data' => $data]);
    }

    public function downloadAllDocuments($employee_row_id)
    {
        $name = DB::table('hr_employees')->select('employee_name')->where('employee_row_id',$employee_row_id)->first();
        $headers = 'documents';
        $files = glob('public/images/employee/'.$employee_row_id.'/');
        Zipper::make('public/images/employee/'.$employee_row_id.'.zip')->add($files);
        
        return Response::download(public_path('images/employee/'.$employee_row_id.'.zip'));
    }

    public function editIncreament($employee_row_id) {
        echo 'you are not authorized to edit it';

    }

    public function institutions(Request $request)
    {
        if ($request->isMethod('post')) {
            if(isset($request->institution_row_id))
            {
                $institution = \App\Models\HrInstitution::find($request->institution_row_id);
                $institution->area_row_id = $request->area_row_id;
                $institution->department_row_id = $request->department_row_id;
                $institution->institution_name = $request->institution_name;
                $institution->short_name = $request->short_name;
                $institution->updated_by = Auth::user()->id;
                $institution->save();
                Session::flash('success-message', 'Institution has been updated successfully');
            }
            else{
                $institution = new HrInstitution;
                $institution->area_row_id = $request->area_row_id;
                $institution->department_row_id = $request->department_row_id;
                $institution->institution_name = $request->institution_name;
                $institution->short_name = $request->short_name;
                $institution->created_by = Auth::user()->id;
                $institution->save();
                Session::flash('success-message', 'Institution has been added successfully');
            }
            return redirect('/hr/manage-institutions');
        }
        else{
            $hrObj = new HrCommon;
            $data['all_areas'] = $hrObj->allAreas(1);
            $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
            $data['institution_list'] = $hrObj->institutions();
            return view($this->viewFolderPath . 'institutions_list', ['data' => $data]);
        }
    }

    public function deleteInstitution($institution_row_id)
    {
        $deleteInstitution=\App\Models\HrInstitution::where('institution_row_id',$institution_row_id)->delete();
        Session::flash('success-message', 'Institution has been deleted successfully');
        return redirect('/hr/manage-institutions');
    }
}
