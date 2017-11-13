<?php
namespace App\Http\Controllers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Redirect;
use \App\Libraries\HrCommon;
use App\Models\Student;
use App\Models\StaffsCard;
use App\Models\StudentsCard;
use App\Models\StaffsAttendanceRecord;
use App\Models\Admin;
use PDF;
use Log;
use Excel;
use Auth;
ini_set('memory_limit', '3000M');
ini_set('max_execution_time', '0');

class ManageAttendanceController extends Controller {

    private $viewFolderPath = 'hr/manage_attendance/';
    private $breadcrumb = 'Manage Attendance';
    

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {          
        $breadcrumb = $this->breadcrumb;
        return view($this->viewFolderPath .  'home', compact('breadcrumb'));
    }
    
    public function manualAttendance() {
       	 $school_row_id = session('school_row_id');
    	 $breadcrumb = $this->breadcrumb;
    	 $allclasses = getSchoolClasses($school_row_id);
    	 $students_list = array();
    	 $show_student_list_section = false;
        return view($this->viewFolderPath .  'manual_entry_create', compact('breadcrumb', 'allclasses', 'students_list', 'show_student_list_section'));
    }
	
	

    // Student manual attendance entry

    public function store(Request $request) {
        $school_row_id = session('school_row_id');        
        $admin_row_id = getSchoolAdmin();
        $date_of_attendance = $request->date_of_attendance;
        
        $inTimeHrArr = $request->in_time_hr;
        $inTimeMinArr = $request->in_time_min;
        $inTimeAmPmArr= $request->in_time_ampm;
        $outTimeHrArr = $request->out_time_hr;
        $outTimeMinArr = $request->out_time_min;
        $outTimeAmPmArr = $request->out_time_ampm;

        $insertData = array();
        dd($insertData);
        for($i=0; $i<count($request->student_ids); $i++) {

            $attendance_available = \App\Models\StudentsAttendanceRecord::where([ ['card_id', $request->student_ids[$i]], ['attendance_date', $date_of_attendance ] ])->first();

         
        $inTimeFinal = '00:00:00';
        if($inTimeAmPmArr[$i])
        {


                if($inTimeAmPmArr[$i] == 'pm')
                    $inTimeFinal =  ($inTimeHrArr[$i] + 12) . ':' . $inTimeMinArr[$i] . ':' . '00';
                else
                    $inTimeFinal =  $inTimeHrArr[$i] . ':' . $inTimeMinArr[$i] . ':' . '00';
          

        }

        $outTimeFinal = '00:00:00';            
        if($outTimeAmPmArr[$i])
        {
                if($outTimeAmPmArr[$i] == 'pm' && $outTimeHrArr[$i]!= 12)
                    $outTimeFinal =  ($outTimeHrArr[$i] + 12) . ':' . $outTimeMinArr[$i] . ':' . '00';
                else
                    $outTimeFinal =  $outTimeHrArr[$i] . ':' . $outTimeMinArr[$i] . ':' . '00';
        }


         $inTimeFinal = $date_of_attendance . ' ' .  $inTimeFinal;
         $outTimeFinal = $date_of_attendance . ' ' .  $outTimeFinal;         


        if($attendance_available) {
                

                $updateData = ['card_id' => $request->student_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance, 'subject_row_id'=> $request->subject_row_id, 'school_row_id'=>$school_row_id, 'updated_by'=> $admin_row_id];

                DB::table('students_attendance_records')->where([ ['card_id', $request->student_ids[$i]], ['attendance_date', $date_of_attendance ] ])->update($updateData);
             } else {
                
                $insertData[] = ['card_id' => $request->student_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance, 'subject_row_id'=> $request->subject_row_id, 'school_row_id'=>$school_row_id, 'created_by'=> $admin_row_id];
                }
          }

        Session::flash('success-message', 'Attendance has been updated successfully.');

        if(!empty($insertData)) {
            \App\Models\StudentsAttendanceRecord::insert($insertData);                  
        }
         
        
        return redirect('schoolAdmin/attendance/studentAttendance');
    }

    //used
    public function manualAttendanceForm( Request $request) { 
        $data[] = '';
        $common_model = new HrCommon();
        $data['all_areas'] = $common_model->allAreas(1);
        $data['departments'] = \App\Models\HrDepartment::select('department_name','department_row_id')->get();
        $data['search_result'] = 0;
        $data['date_of_attendance'] = '';

        if ($request->isMethod('post')) {
            $data['search_result'] = 1;
            $data['date_of_attendance'] = $request->date_of_attendance;
            $area_row_id = $request->area_row_id == -1 ? 0 : $request->area_row_id;
            $date_attendance = $request->date_attendance;
           // $data['employee_list'] = $common_model->employeeListWithAreaIndex($area_row_id);
            $data['employee_list'] = $common_model->attendance_list($data['date_of_attendance'], $area_row_id);
            dd( $data['employee_list']);
            $data['search_result'] = 1;
        }

        $breadcrumb = $this->breadcrumb;
        return view( $this->viewFolderPath . 'manual_attendance_entry', ['data' => $data]);
    }


     public function staffList(Request $request) {
   
    $sql = "SELECT bdedu_admins. admin_row_id, bdedu_admins. admin_name,  (SELECT DATE_FORMAT(first_login, '%H:%i') FROM bdedu_hr_staff_attendance_records WHERE bdedu_admins.`admin_row_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT DATE_FORMAT(last_logout, '%H:%i') FROM bdedu_hr_staff_attendance_records WHERE  bdedu_admins.`admin_row_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM bdedu_admins WHERE bdedu_admins.is_super_admin=2";
    
    $staff_list =  DB::select($sql);


    $date_of_attendance = $request->date_of_attendance;                       
    $breadcrumb = $this->breadcrumb;
    return view( $this->viewFolderPath . 'staff_list', compact('breadcrumb', 'staff_list', 'date_of_attendance'));
       
    }

   
     public function storeStaffAttendance(Request $request) {
        $school_row_id = session('school_row_id');        
        echo $date_of_attendance = $request->date_of_attendance;
       exit;

        //StaffsAttendanceRecord

        $inTimeHrArr = $request->in_time_hr;
        $inTimeMinArr = $request->in_time_min;
        $inTimeAmPmArr= $request->in_time_ampm;
        $outTimeHrArr = $request->out_time_hr;
        $outTimeMinArr = $request->out_time_min;
        $outTimeAmPmArr = $request->out_time_ampm;


        $insertData = array();
        for($i=0; $i<count($request->staff_ids); $i++) {

            $attendance_available = \App\Models\StaffAttendanceRecord::where([ ['card_id', $request->staff_ids[$i]], ['attendance_date', $date_of_attendance ] ])->first();

         
        $inTimeFinal = '00:00:00';
        if($inTimeAmPmArr[$i])
        {
            if($inTimeAmPmArr[$i] == 'pm')
                $inTimeFinal =  ($inTimeHrArr[$i] + 12) . ':' . $inTimeMinArr[$i] . ':' . '00';
            else
                $inTimeFinal =  $inTimeHrArr[$i] . ':' . $inTimeMinArr[$i] . ':' . '00';
        }

        $outTimeFinal = '00:00:00';            
        if($outTimeAmPmArr[$i])
        {
                if($outTimeAmPmArr[$i] == 'pm' && $outTimeHrArr[$i]!= 12)
                    $outTimeFinal =  ($outTimeHrArr[$i] + 12) . ':' . $outTimeMinArr[$i] . ':' . '00';
                else
                    $outTimeFinal =  $outTimeHrArr[$i] . ':' . $outTimeMinArr[$i] . ':' . '00';
        }


         $inTimeFinal = $date_of_attendance . ' ' .  $inTimeFinal;
         $outTimeFinal = $date_of_attendance . ' ' .  $outTimeFinal;         
        
        if($attendance_available) {
                

                $updateData = ['card_id' => $request->staff_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance, 'subject_row_id'=> $request->subject_row_id, 'school_row_id'=>$school_row_id, 'updated_by'=> $admin_row_id];

                DB::table('hr_staff_attendance_records')->where([ ['card_id', $request->staff_ids[$i]], ['attendance_date', $date_of_attendance ] ])->update($updateData);
             } else {

              
                
                $insertData[] = ['card_id' => $request->staff_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance, 'subject_row_id'=> $request->subject_row_id, 'school_row_id'=>$school_row_id, 'created_by'=> $admin_row_id];
                }

          }

        Session::flash('success-message', 'Attendance has been updated successfully.');
       
        if(!empty($insertData)) {
            \App\Models\StaffAttendanceRecord::insert($insertData);                  
        }

         
        
        return redirect('schoolAdmin/attendance/staffAttendance');
    }

     public function staffReportGenerate(Request $request) {
        // show report generate options.
        $school_row_id = session('school_row_id');

        $data['breadcrumb'] = 'Staff Attendance Report';
        $data['date_of_attendance'] = $request->date_of_attendance;

         $sql = "SELECT bdedu_admins.`admin_name`, bdedu_admins.`admin_id`,(SELECT first_login FROM bdedu_hr_staff_attendance_records WHERE bdedu_admins.`admin_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT last_logout FROM bdedu_hr_staff_attendance_records WHERE bdedu_admins.`admin_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM bdedu_admins WHERE bdedu_admins.is_super_admin =2 AND bdedu_admins.school_row_id = $school_row_id";
      

       $data['staff_list'] =  DB::select($sql);
      // dd($data['staff_list']);

        // $data['show_student_list_section']  = true;
        return view($this->viewFolderPath .  'staff_attendance_report', ['data'=>$data] );
        }

        // staff atendance report pdf        
        public function staffReportGeneratePdf($attendance_date) {
        // show report generate options.
        $school_row_id = session('school_row_id');
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
            //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;

        $data['breadcrumb'] = 'Staff Attendance Report';
        $data['attendance_date'] = $attendance_date;

         $sql = "SELECT bdedu_admins.`admin_name`, bdedu_admins.`admin_id`,(SELECT first_login FROM bdedu_hr_staff_attendance_records WHERE bdedu_admins.`admin_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS first_login, (SELECT last_logout FROM bdedu_hr_staff_attendance_records WHERE bdedu_admins.`admin_id` = bdedu_hr_staff_attendance_records.card_id AND bdedu_hr_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS last_logout FROM bdedu_admins WHERE bdedu_admins.is_super_admin =2 AND bdedu_admins.school_row_id = $school_row_id ORDER BY  bdedu_admins.`designation_category_row_id`";      

        $data['staff_attendance_info'] =  DB::select($sql);

        $pdf = PDF::loadView($this->viewFolderPath . 'staff_attendance_report_pdf_download', ['data' => $data]);
        return $pdf->stream($data['attendance_date'].'_staff_attendance_report.pdf');
        
        }


    public function report() {
    	//$this->updateAttendanceRecords();
       	 $school_row_id = session('school_row_id');
    	 $data['breadcrumb'] = 'Attendance Report';
    	 $data['allclasses'] = getSchoolClasses($school_row_id);
    	 $data['students_list']  = array();
    	 $data['show_student_list_section']  = false;
         return view($this->viewFolderPath .  'report_options', ['data'=>$data] );

    }    

    public function reportGenerate(Request $request) {
    	// show report generate options.
       	$school_row_id = session('school_row_id');

       	$academic_department_array = config('site_config.academic_department');
    	$data['breadcrumb'] = 'Attendance Report';
    	$data['allclasses'] = getSchoolClasses($school_row_id);
    	$data['class_name'] = \App\Models\Master_class::where('class_row_id', $request->academic_class)->first()->class_name;
        $data['class_row_id'] = $request->academic_class;
		$data['shift_title'] = \App\Models\SchoolShift::where('shift_row_id', $request->academic_shift)->first()->shift_title;
        $data['shift_row_id'] = $request->academic_shift;
		$data['section_name'] = \App\Models\SchoolSection::where('section_row_id', $request->academic_section)->first()->section_name;
        $data['section_row_id'] = $request->academic_section;
		$data['department_name'] = $academic_department_array[$request->academic_department];
        $data['department_row_id'] = $request->academic_department;        
		$data['date_of_attendance'] = $request->date_of_attendance;

        $sql = "SELECT bdedu_students.`student_name`, bdedu_students.`student_id`, bdedu_students.`current_rollnumber` , (SELECT first_login FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT last_logout FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM bdedu_students WHERE bdedu_students.current_class=$request->academic_class";

    $data['students_list'] =  DB::select($sql);
    

    $data['show_student_list_section']  = true;
    return view($this->viewFolderPath .  'report', ['data'=>$data] );
    }

    public function generatepdf($class_row_id, $shift_row_id, $section_row_id, $department_row_id, $date) {
        //dd($class,$shift,$section,$department);
        
        $school_row_id = session('school_row_id');
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
            //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;

        $academic_department_array = config('site_config.academic_department');
        $data['breadcrumb'] = 'Attendance Report';
        $data['class_name'] = \App\Models\Master_class::where('class_row_id', $class_row_id)->first()->class_name;
        $data['shift_title'] = \App\Models\SchoolShift::where('shift_row_id', $shift_row_id)->first()->shift_title;
        $data['section_name'] = \App\Models\SchoolSection::where('section_row_id', $section_row_id)->first()->section_name;
        $data['department_name'] = $academic_department_array[$department_row_id];

        $data['date_of_attendance'] = $date;
        $school_info = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
       
       $sql = "SELECT bdedu_students.`student_name`, bdedu_students.`student_id`, bdedu_students.`current_rollnumber` , (SELECT first_login FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$date' LIMIT 1) AS first_login, (SELECT last_logout FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$date' LIMIT 1) AS last_logout FROM bdedu_students WHERE bdedu_students.current_class=$class_row_id";

        $data['student_attendance_info'] =  DB::select($sql);
        $pdf = PDF::loadView($this->viewFolderPath . 'attendance_report_pdf_download', ['data' => $data]);
        return $pdf->stream($data['class_name'].'_'.$data['section_name'].'_'.$data['date_of_attendance'].'_attendance_report.pdf');

        // return view($this->viewFolderPath .'attendance_report_pdf_download', ['data'=>$data] );
        }   

    
   

    
    public function staffReport() {
        // show report generate options.
     
        $sql = 'SELECT distinct(EventDate) FROM bdedu_log';
        $attendanceDates = DB::select($sql);
        $insert = [];
        $school_row_id = session('school_row_id');


        foreach($attendanceDates as $dateInfo) 
        {
            Log::info('Attendance records for Date:' . $dateInfo->EventDate);
            if ($dateInfo->EventDate > '0000-00-00') 
            {                             
                $sql = 'SELECT LogId, UserId, EventDate, min(EventTime) as first_login, max(EventTime) as last_logout FROM bdedu_log WHERE EventDate ="'. $dateInfo->EventDate . '"  Group By UserId';
                $attendace_records = DB::select($sql);

                foreach($attendace_records as $recordInfo)
                {
                     Log::info('Attendance records for Card:' . $recordInfo->UserId);

                    $insert[] = [
                                    'card_id'=>$recordInfo->UserId,
                                    'attendance_date'=>$recordInfo->EventDate,
                                    'first_login'=>$recordInfo->first_login,
                                    'last_logout'=>$recordInfo->last_logout,
                                    'school_row_id'=>$school_row_id,
                                ];
                }


            }

        // DB::table('log')->where('EventDate', $dateInfo->EventDate)->delete();

        }

        

        if($insert) {
         DB::table('students_attendance_records')->insert($insert);    
        }
        
      
         $school_row_id = session('school_row_id');
         $data['breadcrumb'] = 'Attendance Report';
         $data['allclasses'] = getSchoolClasses($school_row_id);
         $data['students_list']  = array();
         $data['show_student_list_section']  = false;
         return view($this->viewFolderPath .  'staff_report_option', ['data'=>$data] );
    }
    //used
    public function  sinkAttendanceRecordsFromCsvOption() {
        $data = array();        
        return view($this->viewFolderPath .  'sink_attendance_csv', ['data'=>$data] );
    }
    //used
    public function sinkAttendanceRecordsFromCsv(Request $request) {
         $admin_row_id = Auth::user()->id;
        if(Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count()) {

                foreach ($data as $key => $value) {
                    $id = (int) $value->id;
                    $dateArr = explode('-', $value->date);
                    $attendance_date = 2000 + $dateArr[2] . '-' . $dateArr[1] . '-' . $dateArr[0];
                    $first_login = $attendance_date . ' ' . $value->first_in_time . ':' . '00';
                    $last_logout = $attendance_date . ' ' . $value->last_out_time . ':' . '00';
                    
                    if(DB::table('hr_staff_attendance_records')->where( [ ['card_id', $id], ['attendance_date', $attendance_date] ] )->count() ) {

                        if($value->last_out_time == '0:00')
                            continue; // no need to update as he did not punch card for exit.

                        DB::table('hr_staff_attendance_records')->where([ ['card_id', $id], ['attendance_date', $attendance_date] ])->update(['last_logout' =>$last_logout, 'updated_at'=>getCurrentDateTimeForDB(), 'updated_by'=>$admin_row_id]);   

                    } else {
                         $insertStaffRecords[] = ['card_id' => $id, 'attendance_date'=>$attendance_date, 'first_login' => $first_login, 'last_logout' =>$last_logout, 'created_by'=>$admin_row_id];
                    }
                }

                if(!empty($insertStaffRecords)) {
                    DB::table('hr_staff_attendance_records')->insert($insertStaffRecords);                    
                }
            }
        }

        Session::flash('success-message', 'Attendance Data has been imported successfully');  
        return redirect('hr/attendance/attendance-from-device'); 
    }



    public function absentStaffsToday($pdf = false) {

    $data['student_absent'] = \App\Admin::whereNotIn('admin_id', function($query){
    $query->select('card_id')
    ->from(with(new \App\Models\StaffAttendanceRecord)->getTable())
    ->where('attendance_date', date('Y-m-d'))
    ->where('first_login', '>',  date('Y-m-d') . ' ' . '00:00:00');
    })->where('is_super_admin', 2)->get();

    $data['date_of_attendance'] = date('Y-m-d');
    if($pdf) {
        // make pdf file.
    } else {
        return view($this->viewFolderPath .  'absent_staffs_report', ['data'=>$data] );
    }
    
   
    }

    public function individualStaffReport() {
        $data['all_staffs'] = getAllStaffsBySchoolRowId( session('school_row_id') );
        return view($this->viewFolderPath .  'staff_individual_report_option', ['data'=>$data] );
    }

    public function staffIndividualReportGenerate(Request $request) {
        $data['person_name'] = \App\Admin::where('admin_id', $request->admin_id)->first()->admin_name;
        $data['date_from_attendance'] = $request->date_from_attendance;
        $data['date_to_attendance'] = $request->date_to_attendance;
        $data['card_id'] = $request->admin_id;
        $data['attendance_list'] = \App\Models\StaffAttendanceRecord::where([ ['card_id', $request->admin_id], ['attendance_date', '>=', $request->date_from_attendance], ['attendance_date', '<=', $request->date_to_attendance] ])->orderBy('attendance_date', 'ASC')->get();

        return view($this->viewFolderPath .  'staff_individual_report_view', ['data'=>$data] );
    }

    public function staffIndividualReportPdf($staff_row_id, $start_date, $end_date) {
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
            //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;
        $data['person_name'] = \App\Admin::where('admin_id', $staff_row_id)->first()->admin_name;
        $data['date_from_attendance'] = $start_date;
        $data['date_to_attendance'] = $end_date;
        $data['card_id'] = $staff_row_id;

        $school_info = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_name'] = $school_info->school_name;        
        $data['school_logo'] = $school_info->school_logo;
        $data['school_address'] = getSchoolAddress($school_info);

        $data['attendance_list'] = \App\Models\StaffAttendanceRecord::where([ ['card_id', $staff_row_id], ['attendance_date', '>=', $start_date], ['attendance_date', '<=', $end_date] ])->orderBy('attendance_date', 'ASC')->get();

        $pdf = PDF::loadView($this->viewFolderPath . 'staff_individual_report_pdf', ['data' => $data]);
        return $pdf->stream($data['person_name'] . 'staff_individual_report.pdf');
    }

     public function studentIndividualReportOption() {
        $school_row_id = session('school_row_id');
         $data['breadcrumb'] = 'Attendance Report';
         $data['allclasses'] = getSchoolClasses($school_row_id);
         $data['students_list']  = array();
         $data['show_student_list_section']  = false;
         return view($this->viewFolderPath .  'student_individual_attendance_options', ['data'=>$data] );
    }

     public function studentIndividualReportGenerate(Request $request) {
        $data['student_id'] = $request->student_id;
        $data['student_details'] = \App\Models\Student::where('student_id',  $data['student_id'])->select('student_name','current_class','current_section','current_rollnumber')->first();
        
        $data['section'] = DB::table('school_sections')->where('section_row_id',$data['student_details']->current_section)->first()->section_name;
        $data['person_name'] = \App\Models\Student::where('student_id', $request->student_id)->first()->student_name;
        $data['date_from_attendance'] = $request->date_from_attendance;
        $data['date_to_attendance'] = $request->date_to_attendance;        
        $data['attendance_list'] = \App\Models\StudentsAttendanceRecord::where([ ['card_id', $request->student_id], ['attendance_date', '>=', $request->date_from_attendance], ['attendance_date', '<=', $request->date_to_attendance] ])->orderBy('attendance_date', 'Desc')->get();
        return view($this->viewFolderPath .  'student_individual_attendance_report_view', ['data'=>$data] );
    }


    public function studentIndividualReportPdf($student_id, $start_date, $end_date) {
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
            //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;
        $data['student_details'] = \App\Models\Student::where('student_id', $student_id)->select('student_name','current_class','current_section','current_rollnumber')->first();
        
        $data['section'] = DB::table('school_sections')->where('section_row_id',$data['student_details']->current_section)->first()->section_name;
        $data['date_from_attendance'] = $start_date;
        $data['date_to_attendance'] = $end_date;
        $data['student_id'] = $student_id;

        $data['attendance_list'] = \App\Models\StudentsAttendanceRecord::where([ ['card_id', $student_id], ['attendance_date', '>=', $start_date], ['attendance_date', '<=', $end_date] ])->orderBy('attendance_date', 'ASC')->get();

        $pdf = PDF::loadView($this->viewFolderPath . 'student_individual_report_pdf', ['data' => $data]);
        return $pdf->stream($data['student_details']->student_name . 'student_individual_report.pdf');
    }

}
