<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Session;
use DB;
use Redirect;
use App\Models\Student;
use App\Models\StaffsCard;
use App\Models\StudentsCard;
use App\Models\StaffsAttendanceRecord;
use App\Models\Admin;
use PDF;
use Log;
use Excel;
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
	
	public function manualRFIDSet() {

       	 $school_row_id = session('school_row_id');
    	 $breadcrumb = $this->breadcrumb;
    	 $allclasses = getSchoolClasses($school_row_id);
    	 $students_list = array();
    	 $show_student_list_section = false;
        return view($this->viewFolderPath .  'manual_rfid_set', compact('breadcrumb', 'allclasses', 'students_list', 'show_student_list_section'));
    }

    public function studentsList(Request $request) {
       	$school_row_id = session('school_row_id');
		$academic_department_array = config('site_config.academic_department');
		$class_name = \App\Models\Master_class::where('class_row_id', $request->academic_class)->first()->class_name;
		$shift_title = \App\Models\SchoolShift::where('shift_row_id', $request->academic_shift)->first()->shift_title;
		$section_name = \App\Models\SchoolSection::where('section_row_id', $request->academic_section)->first()->section_name;
		$department_name = $academic_department_array[$request->academic_department];
        $date_of_attendance = $request->date_of_attendance;
			
    	$breadcrumb = $this->breadcrumb;
        $subject_row_id = $request->subject ? $request->subject : 0 ;
        $subject_title = '';
        $subject_title_info =  \App\Models\Subject::where('subject_row_id', $subject_row_id)->first();
        if($subject_title_info)
        $subject_title = $subject_title_info->subject_title;
        
    	$allclasses = getSchoolClasses($school_row_id);
    	$show_student_list_section = true;
		

        $sql = "SELECT bdedu_students. student_row_id, `student_name`, bdedu_students.`student_id`, bdedu_students.`current_rollnumber` , (SELECT DATE_FORMAT(first_login, '%H:%i') FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT DATE_FORMAT(last_logout, '%H:%i') FROM bdedu_students_attendance_records WHERE bdedu_students.`student_id` = bdedu_students_attendance_records.card_id AND bdedu_students_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM bdedu_students WHERE bdedu_students.current_class=$request->academic_class";
        $students_list =  DB::select($sql);

        $breadcrumb = $this->breadcrumb;
        return view( $this->viewFolderPath . 'students_list', compact('breadcrumb', 'allclasses', 'class_name', 'shift_title', 'section_name', 'department_name', 'students_list', 'show_student_list_section', 'subject_title', 'subject_row_id', 'date_of_attendance'));

    }

     /* 
      student manual attendance entry
    
    */

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

    /* 
      staff manual attendance.
    
    */
     public function staffAttendanceOption() {       

         $admin_list = \App\Admin::with('adminDetails', 'staffDesignation', 'staffDesignation.staffDesignationCategory')
                                ->where('school_row_id', session('school_row_id'))        
                                ->where('is_super_admin', 2)    
                                ->orderBy('admin_name', 'desc')
                                ->get();        
        $breadcrumb = $this->breadcrumb;
        return view( $this->viewFolderPath . 'staff_attendance', compact('breadcrumb', 'admin_list'));
       
    }


     public function staffList(Request $request) {
   
    $sql = "SELECT bdedu_admins. admin_row_id, bdedu_admins. admin_name,  (SELECT DATE_FORMAT(first_login, '%H:%i') FROM bdedu_staff_attendance_records WHERE bdedu_admins.`admin_row_id` = bdedu_staff_attendance_records.card_id AND bdedu_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT DATE_FORMAT(last_logout, '%H:%i') FROM bdedu_staff_attendance_records WHERE  bdedu_admins.`admin_row_id` = bdedu_staff_attendance_records.card_id AND bdedu_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM bdedu_admins WHERE bdedu_admins.is_super_admin=2";
    
    $staff_list =  DB::select($sql);


    $date_of_attendance = $request->date_of_attendance;                       
    $breadcrumb = $this->breadcrumb;
    return view( $this->viewFolderPath . 'staff_list', compact('breadcrumb', 'staff_list', 'date_of_attendance'));
       
    }

   
     public function storeStaffAttendance(Request $request) {


        $school_row_id = session('school_row_id');        
        $admin_row_id = getSchoolAdmin();
        $date_of_attendance = $request->date_of_attendance;

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
        if($inTimeAmPmArr[$i]) {
            if($inTimeAmPmArr[$i] == 'pm'  && $inTimeAmPmArr[$i]!= 12)
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

                DB::table('staff_attendance_records')->where([ ['card_id', $request->staff_ids[$i]], ['attendance_date', $date_of_attendance ] ])->update($updateData);
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

    

     

	public function studentsListForRFID(Request $request) {
       	$school_row_id = session('school_row_id');
		$academic_department_array = config('site_config.academic_department');
		$class_name = \App\Models\Master_class::where('class_row_id', $request->academic_class)->first()->class_name;
		$shift_title = \App\Models\SchoolShift::where('shift_row_id', $request->academic_shift)->first()->shift_title;
		$section_name = \App\Models\SchoolSection::where('section_row_id', $request->academic_section)->first()->section_name;
		$department_name = $academic_department_array[$request->academic_department];
			
    	$breadcrumb = $this->breadcrumb;
        $subject_row_id = $request->subject;
      //  $subject_title =  \App\Models\Subject::where('subject_row_id', $request->subject)->first()->subject_title;
        $subject_title = '';
		
    	$allclasses = getSchoolClasses($school_row_id);
    	$show_student_list_section = true;		
		
		$students_list = DB::table('students')
			->select('students.*', 'students_attendance_cards.card_number', 'students_attendance_cards.is_active')
			->where('students.current_session', '=', session('academic_session_row_id'))
			->where('students.current_class', '=', $request->academic_class)
			->where('students.current_shift', '=', $request->academic_shift)
			->where('students.current_section', '=', $request->academic_section)
			->where('students.current_department', '=', $request->academic_department)
            ->where('students.active_status', '=', 1)
            ->leftJoin('students_attendance_cards', 'students_attendance_cards.student_id', '=', 'students.student_id')
			->orderBy('students.current_rollnumber', 'ASC')
            ->get();
        
        $breadcrumb = $this->breadcrumb;
        return view( $this->viewFolderPath . 'students_list_by_rfid', compact('breadcrumb', 'allclasses', 'class_name', 'shift_title', 'section_name', 'department_name', 'students_list', 'show_student_list_section', 'subject_title', 'subject_row_id'));

    }
	public function storeRFID(Request $request) {
		
		//$stucard = \App\Models\StudentsCard
		$student_id = Input::get('student_id');        
		$student_is_active = Input::get('student_is_active');
		
		foreach ($student_id as $tmp_student_id=>$student_row_val) {
			
			//echo $tmp_student_row_id.'>>';
			//echo $student_row_val;			
			$student_card = StudentsCard::where('student_id', '=', $tmp_student_id)->first();
			
			if (empty($student_card)) {
				$student_card =  new StudentsCard;
                $student_card->created_at = getCurrentDateTimeForDB();
                $student_card->created_by = getSchoolAdmin();
			} else {
                $student_card->updated_at = getCurrentDateTimeForDB();
                $student_card->updated_by = getSchoolAdmin();
            }

			$student_card->student_id = $tmp_student_id;
			$student_card->card_number = $student_row_val;
			
            if (isset($student_is_active[$tmp_student_id]))
			$student_card->is_active = $student_is_active[$tmp_student_id];
			else
			$student_card->is_active = 0;
			

			$student_card->save();
            // dd($student_card);
			Session::flash('success-message', 'ID Card Information has been Saved Successfully.');
		}
		return Redirect::to('schoolAdmin/setStudentRFIDCard'); 
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

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) { 
                    $id = (int) $value->id;
                    $dateArr = explode('-', $value->date);
                    $attendance_date = 2000 + $dateArr[2] . '-' . $dateArr[1] . '-' . $dateArr[0];
                    $first_login = $attendance_date . ' ' . $value->first_in_time . ':' . '00';
                    $last_logout = $attendance_date . ' ' . $value->last_out_time . ':' . '00';

                    if($id <  1000) {                        
                        if(DB::table('staff_attendance_records')->where( [ ['card_id', $id], ['attendance_date', $attendance_date] ] )->count() ) {
                            // update last_logout field only  
                            if($value->last_out_time == '0:00')
                                continue; // no need to update as he did not punch card for exit.
                            DB::table('staff_attendance_records')->where([ ['card_id', $id], ['attendance_date', $attendance_date] ])->update(['last_logout' =>$last_logout, 'updated_by'=>$admin_row_id]);   

                        } else {
                             $insertStaffRecords[] = ['card_id' => $id, 'attendance_date'=>$attendance_date, 'first_login' => $first_login, 'last_logout' =>$last_logout, 'created_by'=>$admin_row_id];
                        }
                       
                    } else {

                        if(DB::table('students_attendance_records')->where( [ ['card_id', $id], ['attendance_date', $attendance_date] ] )->count() ) {
                            //// update last_logout field only 
                            if($value->last_out_time == '0:00')
                                continue; // no need to update as he did not punch card for exit.
                            DB::table('students_attendance_records')->where([ ['card_id', $id], ['attendance_date', $attendance_date] ])->update(['last_logout' =>$last_logout, 'updated_by'=>$admin_row_id]);  
                        } else {
                            $insertStudentRecords[] = ['card_id' => $id, 'attendance_date'=>$attendance_date, 'first_login' => $first_login, 'last_logout' =>$last_logout, 'created_by'=>$admin_row_id];
                        }
                        
                    }
                    
                }
                if(!empty($insertStaffRecords)){

                    DB::table('staff_attendance_records')->insert($insertStaffRecords);                    
                }

                if(!empty($insertStudentRecords)){
                    DB::table('students_attendance_records')->insert($insertStudentRecords);                    
                }
            }
        }
        Session::flash('success-message', 'Attendance Data has been imported successfully');  
        return redirect('hr/attendance/all-staff-attendance-report-option'); 
    }

    //used.
    public function allStaffAttendanceReportOption() {   

        return view($this->viewFolderPath .  'staff_report_option');
    }
    //used
    public function allStaffAttendanceReportShow(Request $request) {
        // show report generate options.
        $school_row_id = Auth::user()->id;
        $data['breadcrumb'] = 'Staff Attendance Report';
        $data['date_of_attendance'] = $request->date_of_attendance;
        
        $sql = "SELECT ut_hr_employees.`employee_name`, ut_hr_employees.`contact_1`,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM ut_hr_employees ORDER BY ut_hr_employees.sort_order";
        
        $data['staff_list'] =  DB::select($sql);      
        return view($this->viewFolderPath .  'staff_attendance_report', ['data'=>$data] );
        }


    // used staff atendance report pdf        
    public function allStaffAttendanceReportPdf($attendance_date) {
        // show report generate options.
        $school_row_id = Auth::user()->id;
        $data['breadcrumb'] = 'Staff Attendance Report';
        $data['attendance_date'] = $attendance_date;
       

        $sql = "SELECT ut_hr_employees.`employee_name`, ut_hr_employees.`contact_1` ,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS last_logout FROM ut_hr_employees ORDER BY  ut_hr_employees.sort_order";      

        $data['staff_attendance_info'] =  DB::select($sql);

        $pdf = PDF::loadView($this->viewFolderPath . 'staff_attendance_report_pdf_download', ['data' => $data]);
        return $pdf->stream($data['attendance_date'].'_staff_attendance_report.pdf');
        
        }
    //used
    public function  individualStaffAttendanceReportOption() {

        $data = array();
        $hr_obj = new \App\Libraries\HrCommon();
        $data['all_staffs'] = $hr_obj->employeeList();       
        return view($this->viewFolderPath .  'staff_individual_report_option', ['data'=>$data] );
    }

    public function individualStaffAttendanceReportShow(Request $request) {
        $hr_obj = new \App\Libraries\HrCommon();
        $data['person_info'] = $hr_obj->singleEmployeeInfo($request->employee_row_id);
        $data['date_from_attendance'] = $request->date_from_attendance;
        $data['date_to_attendance'] = $request->date_to_attendance;
        $data['card_id'] = $request->employee_row_id;

        $commonLib = new  \App\Libraries\Common();
        $data['attendance_list'] = $hr_obj->getAttendancesByIdWithDateRange($request->employee_row_id, $request->date_from_attendance, $request->date_to_attendance);

        return view($this->viewFolderPath .  'staff_individual_report_view', ['data'=>$data] );
        
    }

    

        
    public function updateAttendanceRecordsFromLog() {

        $sql = 'SELECT distinct(EventDate) FROM bdedu_log';
        $attendanceDates = DB::select($sql);
        $insertStudentRecords = [];
        $insertStaffRecords = [];
        $school_row_id = session('school_row_id');
        foreach($attendanceDates as $dateInfo) 
        {

            Log::info('Attendance records for Date:' . $dateInfo->EventDate);

            if ($dateInfo->EventDate > '0000-00-00') {                             
                $sql = 'SELECT LogId, UserId, EventDate, min(EventTime) as first_login, max(EventTime) as last_logout FROM bdedu_log WHERE EventDate ="'. $dateInfo->EventDate . '"  Group By UserId';
                $attendace_records = DB::select($sql);

                foreach($attendace_records as $recordInfo)
                {
                    Log::info('Attendance records for Card:' . $recordInfo->UserId);

                   if( (DB::table('students_attendance_records')->where( [ ['card_id', $recordInfo->UserId], ['attendance_date', $dateInfo->EventDate] ] )->count()) || (DB::table('staff_attendance_records')->where( [ ['card_id', $recordInfo->UserId], ['attendance_date', $dateInfo->EventDate] ] )->count()) ) {

                    $tableName = 'students_attendance_records';
                    if( strlen($recordInfo->UserId) < 8 ) {
                        $tableName = 'staff_attendance_records';
                    }

                    DB::table($tableName)
                        ->where([
                             'card_id'=>$recordInfo->UserId, 
                             'attendance_date'=>$dateInfo->EventDate
                        ])->update(['last_logout' => $recordInfo->last_logout]);
                           

                   } else {

                        if( strlen($recordInfo->UserId) < 8 ) {
                            $insertStaffRecords[] = [
                            'card_id'=>$recordInfo->UserId,
                            'attendance_date'=>$recordInfo->EventDate,
                            'first_login'=>$recordInfo->first_login,
                            'last_logout'=>$recordInfo->last_logout,
                            'school_row_id'=>$school_row_id,
                            ];
                        } else {
                            $insertStudentRecords[] = [
                            'card_id'=>$recordInfo->UserId,
                            'attendance_date'=>$recordInfo->EventDate,
                            'first_login'=>$recordInfo->first_login,
                            'last_logout'=>$recordInfo->last_logout,
                            'school_row_id'=>$school_row_id,
                            ];
                        }
                   }
                }
            }

        // DB::table('log')->where('EventDate', $dateInfo->EventDate)->delete();

        }

        

        if($insertStudentRecords) {
         DB::table('students_attendance_records')->insert($insertStudentRecords);    
        }

        if($insertStaffRecords) {
         DB::table('staff_attendance_records')->insert($insertStaffRecords);    
        }

        echo 'Thank you!';
    }

   

    public function staffListForRFID(Request $request) {
        
         $staff_list = DB::table('admins')
                    ->join('staff_attendance_cards','admins.admin_row_id','=','staff_attendance_cards.staff_row_id')
                    ->where('school_row_id', session('school_row_id'))        
                    ->where('is_super_admin', 2)    
                    ->orderBy('admin_row_id', 'asc')
                    ->get();        
        $breadcrumb = $this->breadcrumb;
        return view( $this->viewFolderPath . 'staff_list_by_rfid', compact('breadcrumb', 'staff_list'));

    }

    public function storeStaffRFID(Request $request){

        $staff_row_id = Input::get('staff_row_id');
        $staff_is_active = Input::get('staff_is_active');
        
        foreach ($staff_row_id as $tmp_staff_row_id=>$staff_row_val) {
            // echo $tmp_staff_row_id.'>>';
            // echo $staff_row_val;
            
            $staff_card = StaffsCard::where('staff_row_id', '=', $tmp_staff_row_id)->first();
            
            if (empty($staff_card)){
                $staff_card =  new StaffsCard;
            }
            $staff_card->staff_row_id = $tmp_staff_row_id;
            $staff_card->card_number = $staff_row_val;
            
            if (isset($staff_is_active[$tmp_staff_row_id]))
            $staff_card->is_active = $staff_is_active[$tmp_staff_row_id];
            else
            $staff_card->is_active = 0;
                
            $staff_card->save();
            Session::flash('success-message', 'ID Card Information has been Saved Successfully.');
        }
        return Redirect::to('schoolAdmin/setStaffRFIDCard'); 
    }


    // Students absent today.
    public function absentStudentsToday($pdf = false) {

    $data['student_absent'] = \App\Models\Student::whereNotIn('student_id', function($query){
    $query->select('card_id')
    ->from(with(new \App\Models\StudentsAttendanceRecord)->getTable())
    ->where('attendance_date', date('Y-m-d'))
    ->where('first_login', '>',  date('Y-m-d') . ' ' . '00:00:00');
    })->get();

    $data['date_of_attendance'] = date('Y-m-d');
    if($pdf) {
        // make pdf file.
    } else {
        return view($this->viewFolderPath .  'absent_students_report', ['data'=>$data] );
    }
    
   
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
        $data['person_info'] = \App\Admin::where('admin_id', $request->admin_id)->first();
        $data['date_from_attendance'] = $request->date_from_attendance;
        $data['date_to_attendance'] = $request->date_to_attendance;
        $data['card_id'] = $request->admin_id;
        $commonLib = new  \App\Libraries\Common();
        $data['attendance_list'] = $commonLib->getAttendancesByIdWithDateRange($request->admin_id, $request->date_from_attendance, $request->date_to_attendance);
        return view($this->viewFolderPath .  'staff_individual_report_view', ['data'=>$data] );
    }

    public function staffIndividualReportPdf($admin_id, $date_from_attendance, $date_to_attendance) {
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
        //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;
        $data['person_info'] = \App\Admin::where('admin_id', $admin_id)->first();
        $data['date_from_attendance'] = $date_from_attendance;
        $data['date_to_attendance'] = $date_to_attendance;
        $data['card_id'] = $admin_id;

        $school_info = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_name'] = $school_info->school_name;        
        $data['school_logo'] = $school_info->school_logo;
        $data['school_address'] = getSchoolAddress($school_info);

        $commonLib = new  \App\Libraries\Common();
        $data['attendance_list'] = $commonLib->getAttendancesByIdWithDateRange($admin_id, $date_from_attendance,
            $date_to_attendance);

        $pdf = PDF::loadView($this->viewFolderPath . 'staff_individual_report_pdf', ['data' => $data]);
        return $pdf->stream($data['person_info']->admin_name . 'staff_individual_report.pdf');
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
