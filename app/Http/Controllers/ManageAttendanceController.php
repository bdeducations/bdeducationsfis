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

                    if(DB::table('staff_attendance_records')->where( [ ['card_id', $id], ['attendance_date', $attendance_date] ] )->count() ) {                          
                            
                            if($value->first_in_time == 0)
                                continue; /* no need to update, may be still he did not came office
                               or you are uploading previous csv of this day when he did not came*/

                            DB::table('staff_attendance_records')->where([ ['card_id', $id], ['attendance_date', $attendance_date] ])->update(['first_login' =>$first_login,'last_logout' =>$last_logout, 'updated_by'=>$admin_row_id]);   

                        } else {
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

        $sql = "SELECT ut_hr_employees.`employee_row_id`, ut_hr_employees.`is_part_time`, ut_hr_employees.`employee_name`, ut_hr_employees.`contact_1` ,(SELECT first_login FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS first_login, (SELECT last_logout FROM ut_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_staff_attendance_records.card_id AND ut_staff_attendance_records.`attendance_date` = '$attendance_date' LIMIT 1) AS last_logout FROM ut_hr_employees WHERE ut_hr_employees.show_attendance_report = 1 ORDER BY  ut_hr_employees.sort_order";      

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
        $school_row_id = Auth::user()->id;
        $data['breadcrumb'] = 'Staff Attendance Report';

        $attendance_year = $request->attendance_year;
        $attendance_month = $request->attendance_month;

        $attendance_month = str_pad($attendance_month, 2, "0", STR_PAD_LEFT);
        $data['attendance_year'] = $attendance_year;
        $ob = new \App\Libraries\HrCommon;
        $month_array = $ob->month_array;
        $data['attendance_month'] = $month_array[$attendance_month]; //work here
        $start_date = $attendance_year . '-' . $attendance_month . '-' . '01'; // 1th of the month
        $total_days_in_month = getNumberOfDaysInAMonth($attendance_year, $attendance_month);
        $data['total_working_days_this_month'] =  18; // up to 25th of a month.
        $end_date = $attendance_year . '-' . $attendance_month . '-' . $total_days_in_month; // last day of the month.
        
        // here
        //$data['attendance_date'] = $attendance_date;
        $HrObj = new \App\Libraries\HrCommon();

        $sql = "SELECT `employee_row_id`, `is_part_time`, `employee_name`, `contact_1` FROM ut_hr_employees WHERE show_attendance_report = 1 ORDER BY sort_order";
        $employeeList =  DB::select($sql);

        foreach ($employeeList as $key => $value) {            
            $arr['employee_row_id'] = $value->employee_row_id;
            $arr['employee_name'] = $value->employee_name;
            
            //get Attendace records for a month. it contains those record which i spresent, that has login-logout or login value at leat.
            $attendance_records = $HrObj->getAttendancesByIdWithDateRange($value->employee_row_id, $start_date, $end_date, 1);
            $arr['present_days'] = count($attendance_records);
            $arr['absent_days'] = $data['total_working_days_this_month'] - $arr['present_days'];
            $late_incoming = 0;
            $early_leave = 0;
            $total_time_present_in_a_month = 0;

            foreach ($attendance_records  as $row) {
                
                //calculate total effective hours-minutes in a month.              
                $logout =  date( 'H:i', strtotime($row['last_logout']) );                
                if($logout != '00:00')
                {
                    $total_time_present_in_a_month += strtotime($row['last_logout']) - strtotime($row['first_login']);
                } else {
                    $total_time_present_in_a_month += 5*3600; // if did not logout then treat he was 5 hour in office.
                }

                //calculate late incoming
                $inTimeSupposedTo = strtotime($row['attendance_date'] . ' 09:30:00');
                $inTimeHeWas = strtotime($row['first_login']);
                if($inTimeHeWas > $inTimeSupposedTo) {
                    $late_incoming++;
                }

                //calculate early leave.
                $outTimeSupposedTo = strtotime($row['attendance_date'] . ' 17:30:00');
                $outTimeHeWas = strtotime($row['last_logout']);
                if($outTimeSupposedTo > $outTimeHeWas) {
                    $early_leave++;
                }
            }

            $arr['late_incoming'] = $late_incoming;
            $arr['early_leave'] = $early_leave;
            $arr['total_time_present_in_a_month'] = $total_time_present_in_a_month; 
            $staff_attendance_info[] =$arr;
        }

        $data['staff_attendance_info'] = $staff_attendance_info;
        //dd($data['staff_attendance_info']);

        $pdf = PDF::loadView($this->viewFolderPath . 'all_staff_monthly_attendance_report_pdf', ['data' => $data]);
        return $pdf->stream($attendance_month.'_staff_attendance_report.pdf');
        
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
        $pdf = PDF::loadView($this->viewFolderPath . 'staff_individual_report_pdf', ['data' => $data]);
        return $pdf->stream($data['person_info']->employee_name . 'staff_individual_report.pdf');

    }

}
