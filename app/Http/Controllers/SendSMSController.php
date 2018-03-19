<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use DB;
use App\Models\Admin;
use Illuminate\Support\Facades\Input;
use App\Libraries\Common;
use Session;


class SendSMSController extends Controller
{
    private $viewFolderPath = 'hr/';
    private $breadcrumb = 'Send SMS';


    public function index(){  
        // $sql = "SELECT `employee_row_id`,`sort_order`, `employee_name`, `contact_1`, `department_row_id`, `designation_row_id` FROM `ut_hr_employees` WHERE 1";
        // $data['staff_list'] =  DB::select($sql);  
         

        $data['staff_list'] = \App\Models\HrEmployee::with('employeeDetails','employeeDepartment', 'employeeDesignation')                          
            ->get()->sortBy(function($q) {
            return $q->sort_order;
        }); 
        //dd($data['staff_list']);         
        return view($this->viewFolderPath .  'send_sms', ['data'=>$data] );
    }

    public function sendSMS(Request $request){

    	$user = "bdeducation";
    	$pass="Bdedu312017";
		$sid = "MKMABangla";
	    
	    $url="http://sms.sslwireless.com/pushapi/dynamic/server.php";

    	$sms_text = $request->sms_text1;	    	    	
    	$receiver_list = $request->send_sms;
	
    	// dd($receiver_list);
    	// exit();


	    $sms_text = $this->utf8_to_unicode($sms_text);

	    $i = 0;
	    $param ="user=$user&pass=$pass";   
	    $contact_list = '';
	    foreach($receiver_list as $receiver) {
	      if(! $receiver)
	      continue;

	      if($i==0)
	      $ampersand = ''; 
	      else
	      $ampersand = '&';

	      $contact_list .= $ampersand . "sms[$i][0]= $receiver &sms[$i][1]=".urlencode("$sms_text") ;
	      $i++;
	    }

	   // dd(  $contact_list);

	   	$param = $param . '&' . $contact_list . "&sid=$sid";	   	
	    $crl = curl_init();
	    curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,FALSE);
	    curl_setopt($crl,CURLOPT_SSL_VERIFYHOST,2);
	    curl_setopt($crl,CURLOPT_URL,$url);
	    curl_setopt($crl,CURLOPT_HEADER,0);
	    curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($crl,CURLOPT_POST,1);
	    curl_setopt($crl,CURLOPT_POSTFIELDS,$param);
	    $response = curl_exec($crl);
	    curl_close($crl);
	    Session::flash('success-message','SMS has been sent successfully.');	    
	    return redirect('hr/sendSMS');
	    
    }
    public function utf8_to_unicode($str) {

	    $unicode = array();        
	    $values = array();
	    $lookingFor = 1;

	    for ($i = 0; $i < strlen($str); $i++) {

	        $thisValue = ord($str[$i]);

	        if ($thisValue < 128) 
	            $unicode[] = str_pad(dechex($thisValue), 4, "0", STR_PAD_LEFT);
	        else {
	            if (count($values) == 0) $lookingFor = ($thisValue < 224) ? 2 : 3;                
	            $values[] = $thisValue;                
	            if (count($values) == $lookingFor) {
	                $number = ($lookingFor == 3) ?
	                (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64):
	                (($values[0] % 32) * 64) + ($values[1] % 64);
	                $number = strtoupper(dechex($number));
	                $unicode[] = str_pad($number, 4, "0", STR_PAD_LEFT);
	                $values = array();
	                $lookingFor = 1;
	            } // if
	        } // if
	    } // for
	    $str="";
	    foreach ($unicode as $key => $value) {
	        $str .= $value;
	    }

	    return ($str);   
	}

}