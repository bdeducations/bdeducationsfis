<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Notice_board;
use Redirect;
use DB;
use App\Models\HrAcademicCalendar;
use App\Libraries\Common;
use PDF;
use File;
use Storage;
use League\Flysystem\Filesystem;
use Excel;
use Illuminate\Support\Facades\Input;
use Session;

class ManageCalenderController extends Controller
{
    private $viewFolderPath = 'hr/';
    private $breadcrumb = 'Academic Calendar';

    public function index() {
        $breadcrumb = 'Year Calendar';
    	$event_list = HrAcademicCalendar::orderBy('event_start_date')->get();
        
        return view($this->viewFolderPath.'calender', compact('event_list'));
    }

    public function calenderPdfDownload($format)
    {
        $data['school_info'] = DB::table('schools')->where('school_row_id', session('school_row_id'))->first();
        $data['school_address'] = getSchoolAddress($data['school_info']);
        $school_logo = ($data['school_info']->school_logo != '') ? $data['school_info']->school_logo : 'default_logo.jpg';
        //echo '<pre>'.print_r ($school_info, true).'</pre>'; exit;
        $data['school_logo_url'] = public_path() . '/images/school_images/' . $school_logo;
        $data['breadcrumb'] = 'Year Calendar';
        $data['event_list'] = HrAcademicCalendar::all();

        if($format=='download'){
            $pdf = PDF::loadView($this->viewFolderPath . 'year_calender_pdf',['data'=>$data]);

            return $pdf->download('year_calender'. '.pdf');
         }
        else
            $pdf = PDF::loadView($this->viewFolderPath . 'year_calender_pdf',['data'=>$data]);

        return $pdf->stream('year_calender'. '.pdf');
        
        
    }

    public function storeEventDetails(Request $request) {
        if ($request->isMethod('post')) {
            if(isset($request->event_row_id))
            {
                $event = \App\Models\HrAcademicCalendar::find($request->event_row_id);
                $event->event_title = $request->event_title;
                $event->event_start_date = $request->start_date;
                $event->event_end_date = $request->end_date;
                if($request->end_date == NULL)
                {
                     $event->event_end_date = $request->start_date;
                }
                $event->save();
                Session::flash('success-message', 'Calendar has been updated successfully');
            }
            else{
                $event = new HrAcademicCalendar;
                $event->event_title = $request->event_title;
                $event->event_start_date = $request->start_date;
                $event->event_end_date = $request->end_date;
                if($request->end_date == NULL)
                {
                     $event->event_end_date = $request->start_date;
                }
                $event->save();
                Session::flash('success-message', 'Calendar has been added successfully');
            }
            return redirect('/hr/calender');
        }
    }

    public function deleteEvent($event_row_id){
        if(isset($event_row_id)) {
            $eventRowId = \App\Models\HrAcademicCalendar::find($event_row_id);
            $eventRowId->delete();
            Session::flash('success-message', 'Event has been deleted successfully');
            return redirect('/hr/calender');
        }
    }

    public function viewCalender(){
        $breadcrumb = 'View Year Calendar';
        $event_list = HrAcademicCalendar::orderBy('event_start_date')->get();

        return view($this->viewFolderPath.'view_calendar', compact('event_list','breadcrumb'));
    }
    
    public function viewAsCalendar(){
        $breadcrumb = 'View Year Calendar';
        $event_list = HrAcademicCalendar::orderBy('event_start_date')->get();

        $events = [];

        foreach($event_list as $data) {
            // echo $event_end_date = strtotime("+1 days", strtotime($data['event_end_date']));
            // echo '<br>';
            // echo date('Y-m-d', $dateNoFormat);
            $event_end_date_ar = explode('-', $data['event_end_date']);
            $event_end_date = date('Y-m-d', mktime(0, 0, 0, $event_end_date_ar[1], $event_end_date_ar[2], $event_end_date_ar[0]) + 86400);

            $events[] = \Calendar::event(
                $data['event_title'], //event title
                true, //full day event?
                $data['event_start_date'], //start time (you can also use Carbon instead of DateTime)
                $event_end_date , //end time (you can also use Carbon instead of DateTime)
                'stringEventId' //optionally, you can specify an event ID
            );
        }

        $calendar = \Calendar::addEvents($events) //add an array with addEvents
            ->setOptions([ //set fullcalendar options
                'firstDay' => 0,
                'displayEventTime' => true,
                'weekends' => true,
                'eventLimit' => 3,
            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                //'viewRender' => 'function() {alert("Callbacks!");}'
            ]);
        
        return view($this->viewFolderPath.'view_as_calendar', compact('calendar','breadcrumb','event_list'));
    }
}