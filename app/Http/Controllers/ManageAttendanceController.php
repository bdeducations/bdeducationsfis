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
use App\Libraries\Common;
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
            //dd($data);

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) { 
                    $id = (int) $value->id;
                    $dateArr = explode('/', $value->date);
                    
                    // attendance new rule
                    $min_in_time = strtotime('08:45');
                    $max_out_time = strtotime('18:15');
                    $in_time = strtotime($value->first_in_time);
                    $out_time = strtotime($value->last_out_time);
                    if($in_time < $min_in_time)
                    {
                       $value->first_in_time =  '08:45';
                    }
                    if($out_time > $max_out_time)
                    {
                        $value->last_out_time = '18:15';
                    }

                    $attendance_date = $dateArr[2] . '-' . $dateArr[0] . '-' . $dateArr[1];
                    $first_login = $attendance_date . ' ' . $value->first_in_time . ':' . '00';
                    $last_logout = $attendance_date . ' ' . $value->last_out_time . ':' . '00';

                    if(DB::table('staff_attendance_records')->where( [ ['card_id', $id], ['attendance_date', $attendance_date] ] )->count() ) {                          
                            
                            if($value->first_in_time == 0)
                                continue; /* no need to update, may be still he did not came office
                               or you are uploading previous csv of this day when he did not came*/

                            DB::table('staff_attendance_records')->where([ ['card_id', $id], ['attendance_date', $attendance_date] ])->update(['first_login' =>$first_login,'last_logout' =>$last_logout, 'updated_by'=>$admin_row_id]);   

                        } else {
                            //dd($first_login);
                            $insertStaffRecords[] = ['card_id' => $id, 'attendance_date'=>$attendance_date, 'first_login' => $first_login, 'last_logout' =>$last_logout, 'created_by'=>$admin_row_id];
                        }
                       
                    } 
               
                if(!empty($insertStaffRecords)){

                    DB::table('staff_attendance_records')->insert($insertStaffRecords);                    
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

        
        $sql = "SELECT ut_hr_employees.`employee_row_id`, ut_hr_employees.`employee_name`, ut_hr_employees.`contact_1`,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout FROM ut_hr_employees WHERE ut_hr_employees.show_attendance_report = 1 ORDER BY ut_hr_employees.sort_order";
        $data['staff_list'] =  DB::select($sql);      
        return view($this->viewFolderPath .  'staff_attendance_report', ['data'=>$data] );
        }


    // used staff atendance report pdf        
    public function allStaffAttendanceReportPdf($attendance_date) {
        // show report generate options.
        $school_row_id = Auth::user()->id;
        $data['breadcrumb'] = 'Staff Attendance Report';
        $data['attendance_date'] = $attendance_date;

        $sql = "SELECT ut_hr_employees.`employee_row_id`, ut_hr_employees.`is_part_time`, ut_hr_employees.`employee_name`, ut_hr_employees.`contact_1`,ut_hr_employees.`in_time_supposed`, ut_hr_employees.`out_time_supposed` ,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS last_logout FROM ut_hr_employees WHERE ut_hr_employees.show_attendance_report = 1 ORDER BY  ut_hr_employees.sort_order";      

        $data['staff_attendance_info'] =  DB::select($sql);

        $pdf = PDF::loadView($this->viewFolderPath . 'staff_attendance_report_pdf_download', ['data' => $data]);
        return $pdf->stream($data['attendance_date'].'_staff_attendance_report.pdf');
        
        }

    //used.
    public function allStaffAttendanceMonthlyReportOption() {   

        return view($this->viewFolderPath .  'staff_report_monthly_option');
    }
    
    // used staff atendance report pdf        
    public function allStaffAttendanceMonthlyReportPdf(Request $request) {
        // show report generate options.
        $per_day_hour = 9;
        $per_day_more_1 = 11; //usually for office peon
        $data['people_under_per_day_more_1'] = [133, 134];

        $school_row_id = Auth::user()->id;
        $data['breadcrumb'] = 'Staff Attendance Report';
        $attendance_year = $request->attendance_year;
        $attendance_month = $request->attendance_month;
        $data['attendance_year'] = $attendance_year;
        $ob = new \App\Libraries\HrCommon;
        // $month_array = $ob->month_array;
        // $data['attendance_month'] = $month_array[$attendance_month]; //month name to show in report
        // $start_date = $attendance_year . '-' . $attendance_month . '-' . '01'; // 1th of the month
        //$total_days_in_month = getNumberOfDaysInAMonth($attendance_year, $attendance_month);
        $data['total_working_days_this_month'] =  $request->total_working_days ; // up to 24th of a month.
        $data['total_working_hours_this_month'] =  $data['total_working_days_this_month'] * $per_day_hour;
        $data['total_working_hours_more_1_this_month'] =  $data['total_working_days_this_month'] * $per_day_more_1;
        $data['start_date'] = $request->date_from;
        $data['end_date'] = $request->date_to;   
        //$end_date = $attendance_year . '-' . $attendance_month . '-' . $total_days_in_month; // last day of the month.       

        //$attendance_month = str_pad($attendance_month, 2, "0", STR_PAD_LEFT);
        if($attendance_month == 1) { 
            $prev_year = $attendance_year - 1;
            $prev_month = 12;
            $data['prev_attendance_month'] = 'December'; //month name show in report
            $start_date = $request->date_from;
            $end_date = $request->date_to;   
        } else {
            $prev_month = $attendance_month - 1;
            $start_date = $request->date_from;
            $end_date = $request->date_to;   
        }       
    
        // here
        //$data['attendance_date'] = $attendance_date;
        $HrObj = new \App\Libraries\HrCommon();

        $sql = "SELECT `employee_row_id`, `is_part_time`, `is_part_time`, `employee_name`, `contact_1`, `in_time_supposed`, `out_time_supposed`  FROM ut_hr_employees WHERE show_attendance_report = 1 AND active_status = 1 ORDER BY employee_row_id";
        $employeeList =  DB::select($sql);

        foreach ($employeeList as $key => $value) {            
            $arr['employee_row_id'] = $value->employee_row_id;
            $arr['employee_name'] = $value->employee_name;
            $arr['is_part_time'] = $value->is_part_time;
         
            
            //get Attendace records for a month. it contains those record which i spresent, that has login-logout or login value at least.
            $attendance_records = $HrObj->getAttendancesByIdWithDateRange($value->employee_row_id, $start_date, $end_date, 1);
            //dd($attendance_records);
            $arr['present_days'] = count($attendance_records);
            $arr['absent_days'] = $data['total_working_days_this_month'] - $arr['present_days'];
            $late_incoming = 0;
            $early_leave = 0;
            $total_time_present_in_a_month = 0;
           
            $demerit_point_count = 0;
            $total_demerit = 0;
            foreach ($attendance_records  as $row) {
                //Demerit point count
                // dd($row['first_login']);
                $time = date("H:i:s",strtotime($row['first_login']));
                $past_in_time = strtotime($time);
                $should_be_in_time = strtotime('09:05');
                if($past_in_time>$should_be_in_time){
                    $demerit_point_count++;
                }
                else{
                    $demerit_point_count = 0;
                }
                if($demerit_point_count ==3){
                    $total_demerit++;
                    $demerit_point_count = 0;
                }
                
                // do not count device record if manual hour is counted.
                if($row['count_manual_hours'] >0 || $row['count_manual_minutes']>0) {
                    $total_time_present_in_a_month += ($row['count_manual_hours']*3600 + $row['count_manual_minutes']*60); 
                    continue;
                }
                
                //calculate total effective hours-minutes in a month.              
                $logout =  date( 'H:i', strtotime($row['last_logout']) );                
                if($logout != '00:00')
                {
                    $total_time_present_in_a_month += strtotime($row['last_logout']) - strtotime($row['first_login']);
                } else {
                    //$total_time_present_in_a_month += 5*3600; // if did not logout then treat he was 5 hour in office.
                }

                //calculate late incoming   out_time_supposed
                $inTimeSupposedTo = strtotime($row['attendance_date'] . ' ' . $value->in_time_supposed);
                $inTimeHeWas = strtotime($row['first_login']);
                if($inTimeHeWas > $inTimeSupposedTo) {
                    $late_incoming++;
                }

                //calculate early leave.
                $outTimeSupposedTo = strtotime($row['attendance_date'] . ' ' .  $value->out_time_supposed);
                $outTimeHeWas = strtotime($row['last_logout']);
                if($outTimeSupposedTo > $outTimeHeWas) {
                    $early_leave++;
                }
            }
            //dd($total_demerit);
            $arr['total_demerit'] = $total_demerit;
            $arr['late_incoming'] = $late_incoming;
            $arr['early_leave'] = $early_leave;
            //$arr['total_time_present_in_a_month'] = $total_time_present_in_a_month; 
            $arr['total_time_present_in_a_month'] = ceil($total_time_present_in_a_month/3600); 

            //casual leave, sick leave 
            $arr['number_of_leave'] = DB::table('hr_employee_leave_records')
                                      ->where([ 
                                            ['employee_row_id', $value->employee_row_id],
                                            ['leave_date_from',  '>=', $start_date],
                                            ['leave_date_to', '<=', $end_date  ] 
                                        ])->whereIn('leave_type', [1, 2])->sum('number_of_days');

            

            //count all tour days
            $arr['number_of_tour'] = DB::table('hr_employee_leave_records')
                                      ->where([ 
                                                ['employee_row_id', $value->employee_row_id],
                                                ['leave_type', 3],
                                                ['leave_date_from',  '>=', $start_date],
                                                ['leave_date_to', '<=', $end_date  ] 
                                            ])->sum('number_of_days');

            $arr['unauthorized_leave'] = DB::table('hr_employee_leave_records')
                                      ->where([ 
                                                ['employee_row_id', $value->employee_row_id],
                                                ['leave_type', 4],
                                                ['leave_date_from',  '>=', $start_date],
                                                ['leave_date_to', '<=', $end_date  ] 
                                            ])->sum('number_of_days');

            // all hour including working and leave, tour.                      

            $arr['total_hour_including_leave'] =  $arr['total_time_present_in_a_month'] + ($arr['number_of_leave'] * 9 )+ ($arr['number_of_tour'] * 9);   

            $staff_attendance_info[] =$arr;
        }

        $data['staff_attendance_info'] = $staff_attendance_info;
        //dd($data['staff_attendance_info']);

        if($request->report_type == 1) { //pdf report
             $pdf = PDF::loadView($this->viewFolderPath . 'all_staff_monthly_attendance_report_pdf', ['data' => $data]);
            return $pdf->stream($attendance_month.'_staff_attendance_report.pdf');

        } else { //excel report
            $data =  $staff_attendance_info;
            $excel_file_name = 'all_staff_monthly_attendance_report_excel';
            Excel::create($excel_file_name, function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->download('csv');
        }
        
    }

    //used
    public function  individualStaffAttendanceReportOption() {
        

        $data = array();
        $hr_obj = new \App\Libraries\HrCommon();
        $data['all_staffs'] = $hr_obj->employeeList();       
        return view($this->viewFolderPath .  'staff_individual_report_option', ['data'=>$data] );
    }
    //used
    public function individualStaffAttendanceReportShow(Request $request) {
        
        $hr_obj = new \App\Libraries\HrCommon();
        $data['person_info'] = $hr_obj->singleEmployeeInfo($request->employee_row_id);
        $data['date_from_attendance'] = $request->date_from_attendance;
        $data['date_to_attendance'] = $request->date_to_attendance;
        $data['card_id'] = $request->employee_row_id;        
        //up to this done 11-15-2017.
        $data['attendance_list'] = $hr_obj->getAttendancesByIdWithDateRange($request->employee_row_id, $request->date_from_attendance, $request->date_to_attendance);
        //dd($data['attendance_list'] );
        $demerit_point_count = 0;
        $total_demerit = 0;
        foreach ($data['attendance_list']  as $row) {
            //Demerit point count
            //dd($row['first_login']);
            if($row){
               $time = date("H:i:s",strtotime($row['first_login']));
                $past_in_time = strtotime($time);
                $should_be_in_time = strtotime('09:05');
                if($past_in_time>$should_be_in_time){
                    $demerit_point_count++;
                }
                else{
                    $demerit_point_count = 0;
                }
                if($demerit_point_count ==3){
                    $total_demerit++;
                    $demerit_point_count = 0;
                } 
            }
            
        }
        //dd($total_demerit);
        $data['total_demerit']= $total_demerit;
        
        return view($this->viewFolderPath .  'staff_individual_report_view', ['data'=>$data] );
    }
    // used, working
    public function staffIndividualReportPdf($employee_row_id, $date_from_attendance, $date_to_attendance) {
        $hr_obj = new \App\Libraries\HrCommon();
        $data['person_info'] = $hr_obj->singleEmployeeInfo($employee_row_id);
        $data['date_from_attendance'] = $date_from_attendance;
        $data['date_to_attendance'] = $date_to_attendance;
        $data['card_id'] = $employee_row_id;
        
        $data['attendance_list'] = $hr_obj->getAttendancesByIdWithDateRange($employee_row_id, $date_from_attendance,
            $date_to_attendance);
        $demerit_point_count = 0;
        $total_demerit = 0;
        foreach ($data['attendance_list']  as $row) {
            //Demerit point count
            //dd($row['first_login']);
            if($row){
               $time = date("H:i:s",strtotime($row['first_login']));
                $past_in_time = strtotime($time);
                $should_be_in_time = strtotime('09:05');
                if($past_in_time>$should_be_in_time){
                    $demerit_point_count++;
                }
                else{
                    $demerit_point_count = 0;
                }
                if($demerit_point_count ==3){
                    $total_demerit++;
                    $demerit_point_count = 0;
                } 
            }
            
        }
        //dd($total_demerit);
        $data['total_demerit']= $total_demerit;
        
        $pdf = PDF::loadView($this->viewFolderPath . 'staff_individual_report_pdf', ['data' => $data]);
        return $pdf->stream($data['person_info']->employee_name . 'staff_individual_report.pdf');

    }

    //Manual Attendance
    public function allStaffManualAttendance() {   

        return view($this->viewFolderPath .  'staff_manual_attendance');
    }

    public function manualAttendanceForm(Request $request) {

        $data['breadcrumb'] = 'Manual Attendance';
        $data['date_of_attendance'] = $request->date_of_attendance;

    }

     public function getStaffList(Request $request) {
      $data['date_of_attendance'] = $request->date_of_attendance;

        
        $sql = "SELECT ut_hr_employees.`employee_row_id`, ut_hr_employees.`employee_name`,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS last_logout, (SELECT count_manual_hours FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$request->date_of_attendance' LIMIT 1) AS count_manual_hours FROM ut_hr_employees WHERE ut_hr_employees.show_attendance_report = 1 ORDER BY ut_hr_employees.sort_order";
        $data['staff_list'] =  DB::select($sql);  
        //dd($data['staff_list']);
      return view($this->viewFolderPath .  'staff_list', ['data'=>$data] );
    }

    public function storeManualAttendance(Request $request)
    {
        $date_of_attendance = $request->date_of_attendance;

        //StaffsAttendanceRecord

        $inTimeHrArr = $request->in_time_hr;
        $inTimeMinArr = $request->in_time_min;
        $inTimeAmPmArr= $request->in_time_ampm;
        $outTimeHrArr = $request->out_time_hr;
        $outTimeMinArr = $request->out_time_min;
        $outTimeAmPmArr = $request->out_time_ampm;
        
        //dd( $count_manual_hours);
        $insertData = array();
        for($i=0; $i<count($request->staff_ids); $i++) {
            $attendance_available = \App\Models\StaffAttendanceRecord::where([ ['card_id', $request->staff_ids[$i]], ['attendance_date', $date_of_attendance ] ])->first();

            $inTimeFinal = '00:00:00';
            if($inTimeAmPmArr[$i])
            {
                if($inTimeAmPmArr[$i] == 'pm' && $inTimeHrArr[$i] !=12)
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
            
            
            if($request->count_manual_hours && $request->total_hour) {               
                    $updateData = ['card_id' => $request->staff_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance,
                    'count_manual_hours' => $request->total_hour[$i] ,'updated_by'=> Auth::id(), 'updated_at' => date('Y-m-d H:i:s')];
                    DB::table('staff_attendance_records')->where([ ['card_id', $request->staff_ids[$i]], ['attendance_date', $date_of_attendance ] ])->update($updateData);
                 } 
            else{

                   //never comes here.
                    //$insertData[] = ['card_id' => $request->staff_ids[$i], 'first_login'=>$inTimeFinal, 'last_logout'=>$outTimeFinal, 'attendance_date' => $date_of_attendance,'count_manual_hours' => $request->total_hour[$i],'created_by'=> Auth::id()];
                }

          }


        Session::flash('success-message', 'Attendance has been updated successfully.');
       
        if(!empty($insertData)) {
           //  \App\Models\StaffAttendanceRecord::insert($insertData);                  
        }         
        
        return redirect('hr/attendance/manual-attendance');


    }

}
