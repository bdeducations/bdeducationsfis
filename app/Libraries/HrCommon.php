<?php
namespace App\Libraries;
use Illuminate\Support\Facades\Input;
use Image;
use DB;
use File;

class HrCommon
{
	public $output = array();
	public $head_child_list = array();
	public $head_parent_list = array();
	public $head_amount = array();
	public $parent_head_child_list = array();
	public $head_total_expense_by_month = array();
	public $month_array = array(
		'1' => 'January',
		'2' => 'February',
		'3' => 'March',
		'4' => 'April',
		'5' => 'May',
		'6' => 'June',
		'7' => 'July',
		'8' => 'August',
		'9' => 'September',
		'10' => 'October',
		'11' => 'November',
		'12' => 'December'
		);

	public function uploadImage($fileInputField, $uploadFolder, $fileName = '', $create_thumb = false, $photoIndex = false)
	{                        
		$uploadedFileName = '';

		if (Input::file($fileInputField)) 
		{	

			$fileName = preg_replace('/\s*/', '', $fileName);
			$fileName = strtoupper($fileName);
			$fileInfo = Input::file($fileInputField);
			if (is_array($fileInfo))
				$fileInfo = $fileInfo[$photoIndex];


			$uploadedFileName = $fileName . '.' . $fileInfo->getClientOriginalExtension();

			//Upload Thumbnail Image
			if($create_thumb) {
				$upload_thumb_path = public_path($uploadFolder.'/thumbs');			
				if(!File::exists($upload_thumb_path)) {
					File::makeDirectory($upload_thumb_path, $mode = 0777, true, true);
				}
				Image::make($fileInfo->getRealPath())->resize(150, 150)->save($upload_thumb_path.'/'.$uploadedFileName);
			}

			//Upload Original Image
			$upload_path = public_path($uploadFolder);
			if(!File::exists($upload_path)) {
				File::makeDirectory($upload_path, $mode = 0777, true, true);
			}			
			$fileInfo->move($upload_path, $uploadedFileName);
		}

		return $uploadedFileName; 

	}

	public function getDistricts($divisionid, $presentdist = NULL) {
		$alldistricts = DB::table('hr_districts')->select('id','full_name')->where('division_id', $divisionid)->orderBy('full_name', 'asc')->get();
		$html = "";
		$html .= "<option value='0'>Select District</option>";
		foreach($alldistricts as $districts) {	
			if(isset($presentdist) && ($districts->id == $presentdist)) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}

			$html .= "<option value=".$districts->id." ".$selected.">".$districts->full_name."</option>";
		}
		echo $html;
	}

	public function getUpazilas($districtid, $presentupazila = NULL) {
		$allupazilas = DB::table('upazila')->select('id','full_name')->where('district_id',$districtid)->orderBy('full_name', 'asc')->get();
		$html = "";
		$html .= "<option value='0'>Select Upazila</option>";	
		foreach($allupazilas as $upazilas) {
			if(isset($presentupazila) && ($upazilas->id == $presentupazila)) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			$html .= "<option value=".$upazilas->id." ".$selected.">".$upazilas->full_name."</option>";
		}
		echo $html;
	}

	public function getDesignations($department_row_id = 0, $current_designation = 0) {	

		$designations = DB::table('hr_designations')->where('department_row_id',$department_row_id)->get();
		$html = "";
		foreach($designations as $designation) {
			if(isset($current_designation) && ($designation->designation_row_id == $current_designation)) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			$html .= "<option value=" . $designation->designation_row_id . " " . $selected . ">" . $designation->designation_name . "</option>";
		}
		echo $html;

	}

    public function destroy($id)
    {
    	$file = Upload::find($id);
    	$filename = Input::get('database field name for file');
    	$path = public_path().'/path/to/file/';

    	if (!File::delete($path.$filename))
    	{
    		Session::flash('flash_message', 'ERROR deleted the File!');
    		return Redirect::to('page name');
    	}
    	else
    	{
    		$file->delete();
    		Session::flash('flash_message', 'Successfully deleted the File!');
    		return Redirect::to('page name');
    	}

    }
    
    public function employeeList($department_row_id=0)
    {

        if($department_row_id) {
        return \App\Models\HrEmployee::with('employeeDepartment', 'employeeDesignation')
                            ->where('department_row_id',$department_row_id)
                            ->get()->sortBy(function($q) { 
                            return $q->employeeDesignation->sort_order;
                        });
        } else {            
            $output = [];
                $allArea = $this->allAreas(1);              
                if(count($allArea)) {                    
                    foreach ($allArea as $area) { 
                        $output[$area->title] =  \App\Models\HrEmployee::with('employeeDepartment', 'employeeDesignation')
                            ->where('area_row_id',$area->area_row_id)
                            ->orderBy('department_row_id','ASC')
                            ->get();
                    }
                }
            return  $output;
        }
      
    }

    public function employeeListWithAreaIndex($area_row_id=0)
    {
        
        $output = [];
        if($area_row_id) {
            $allArea = \App\Models\Area::where('area_row_id', $area_row_id)->get();
        } else {
            $allArea = $this->allAreas(1);
        }
        if(count($allArea)) {                    
            foreach ($allArea as $area) { 
                $output[$area->title] =  \App\Models\HrEmployee::with('employeeDepartment', 'employeeDesignation')
                    ->where('area_row_id',$area->area_row_id)
                    ->orderBy('department_row_id','designation_row_id','ASC')
                    ->get();
            }
        }

        return  $output;      
    }

    public function singleEmployeeInfo($employee_row_id)
    {
        return \App\Models\HrEmployee::with('employeeDetails','employeeDepartment', 'employeeDesignation')
                            ->where('employee_row_id',$employee_row_id)
                            ->first();

    }

    public function departments()
    {
        return \App\Models\HrDepartment::where('is_active',1)->orderBy('sort_order')->get();

    }

    public function designations()
    {
      return \App\Models\HrDesignation::with('department_info')->where('is_active',1)->orderBy('department_row_id')->orderBy('sort_order')->get();
    }

    
    public function setSalaryHeadsPaySettings($fiscal_year = 2017) {
    	//DB Query causign issue
    	/*
		return DB::table('hr_salary_heads As sh')
    				->leftjoin('hr_salary_head_pay_amounts As shp', function ($join) use ($fiscal_year) {
                		$join->on('sh.salary_head_row_id', '=', 'shp.salary_head_row_id');
                		$join->on('shp.fiscal_year', '=',  '2017');
            		})->get();
            		*/
        $sql = "SELECT h.salary_head_slug, h.salary_head_name, hp.* FROM ut_hr_salary_heads h LEFT JOIN `ut_hr_salary_head_pay_amounts` hp ON h.`salary_head_row_id`=hp.`salary_head_row_id` AND  hp.fiscal_year= $fiscal_year";

        return DB::select($sql);
    }

    public function getSalaryHeadsPaySettings($fiscal_year = 2017) {
    	//DB Query causign issue
    	/*
		return DB::table('hr_salary_heads As sh')
    				->leftjoin('hr_salary_head_pay_amounts As shp', function ($join) use ($fiscal_year) {
                		$join->on('sh.salary_head_row_id', '=', 'shp.salary_head_row_id');
                		$join->on('shp.fiscal_year', '=',  '2017');
            		})->get();
            		*/
        $sql = "SELECT h.salary_head_slug, h.salary_head_name, hp.* FROM ut_hr_salary_heads h JOIN `ut_hr_salary_head_pay_amounts` hp ON h.`salary_head_row_id`=hp.`salary_head_row_id` AND  hp.fiscal_year= $fiscal_year";

        return DB::select($sql);
    }

    public function getEmployeeStartingSalary($employee_row_id) {
    	return \App\Models\HrEmployeeHistory::where('employee_row_id', $employee_row_id)->where('is_starting_salary', 1)->first();

    }

    public function getEmployeeCurrentSalary($employee_row_id) {
    	return \App\Models\HrEmployeeHistory::where('employee_row_id', $employee_row_id)->orderBy('employee_history_row_id', 'desc')->first();

    }


    public function allAreas($status = 0) {
        if ($status == 1) {
            $area_list = \App\Models\Area::where('status', 1)->orderBy('sort_order', 'asc')->get();
        } else {
            $area_list = \App\Models\Area::orderBy('sort_order', 'asc')->get();
        }
        return $area_list;
    }

    

    public function getOtherThanStartingSalary($employee_row_id) {
    	return \App\Models\HrEmployeeHistory::with('employeeDepartment', 'employeeDesignation')->where('employee_row_id', $employee_row_id)->where('is_starting_salary', 0)->orderBy('employee_history_row_id', 'desc')->get();

    }

    public function getAllSalaryRecords($employee_row_id) {
    	return \App\Models\HrEmployeeHistory::with('employeeDepartment', 'employeeDesignation')->where('employee_row_id', $employee_row_id)->orderBy('employee_history_row_id', 'desc')->get();

    }

    public function getEmployeePerformanceComments($employee_row_id) {
    	return \App\Models\HrEmployeePerformanceComments::with('userInfo')->where('employee_row_id', $employee_row_id)->orderBy('employee_performance_comment_row_id', 'desc')->get();

    }

    public function getEmployeeList($institution_row_id,$current_employee)
    {
    	$employeeList = \App\Models\HrEmployee::with('employeeDepartment', 'employeeDesignation')
      						->where('institution_row_id',$institution_row_id)
                            ->orderBy('department_row_id','designation_row_id','ASC')
                            ->get();
        $html = "";
        $html .= "<option value=''>Select</option>";
		foreach($employeeList as $employee) {
			if(isset($current_employee) && ($employee->employee_row_id == $current_employee)) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			$html .= "<option value=" . $employee->employee_row_id . " " . $selected . ">" . $employee->employee_name . "</option>";
		}
		echo $html;
    }

    public function institutions()
    {
      return \App\Models\HrInstitution::with('sector_info','area_name')->where('is_active',1)->orderBy('department_row_id')->orderBy('sort_order')->get();
    }

    public function getInstitutions($area_row_id,$department_row_id,$current_institution_id)
    {
        if($area_row_id <0)
        {
            $institution_list = \App\Models\HrInstitution::where([['department_row_id',$department_row_id]])->orderBy('institution_row_id')->orderBy('sort_order')->get();
            $html = "";
            $html .= "<option value=''>Select</option>";
            foreach($institution_list as $institutions) {
                if(isset($current_institution_id) && ($institutions->institution_row_id == $current_institution_id)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $html .= "<option value=" . $institutions->institution_row_id . " " . $selected . ">" . $institutions->institution_name . "</option>";
            }
            echo $html;
        }
        else{
            $institution_list = \App\Models\HrInstitution::where([['area_row_id',$area_row_id],['department_row_id',$department_row_id]])->orderBy('institution_row_id')->orderBy('sort_order')->get();
            $html = "";
            $html .= "<option value=''>Select</option>";
            foreach($institution_list as $institutions) {
                if(isset($current_institution_id) && ($institutions->institution_row_id == $current_institution_id)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $html .= "<option value=" . $institutions->institution_row_id . " " . $selected . ">" . $institutions->institution_name . "</option>";
            }
            echo $html;
        }
        
    }

    public function attendance_list($date_of_attendance, $area_row_id) {
        $areaCond = $area_row_id ? 'WHERE ut_hr_employees.area_row_id='.$area_row_id : '';
        
        if($area_row_id) {
            echo $sql = "SELECT ut_hr_employees. employee_row_id, ut_hr_employees. employee_id, ut_hr_employees. employee_name,  (SELECT DATE_FORMAT(first_login, '%H:%i') FROM ut_hr_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_hr_staff_attendance_records.card_id AND ut_hr_staff_attendance_records.`attendance_date` = '$date_of_attendance' LIMIT 1) AS first_login, (SELECT DATE_FORMAT(last_logout, '%H:%i') FROM ut_hr_staff_attendance_records WHERE  ut_hr_employees.`employee_row_id` = ut_hr_staff_attendance_records.card_id AND ut_hr_staff_attendance_records.`attendance_date` = '$date_of_attendance' LIMIT 1) AS last_logout FROM ut_hr_employees $areaCond";
            $arr['jamalpur'] =  DB::select($sql);
        } else {
            $output = [];
            $allArea = $this->allAreas(1);              
            if(count($allArea)) {                    
                foreach ($allArea as $area) {
                    $areaCond = $area->area_row_id ? 'WHERE ut_hr_employees.area_row_id='.$area->area_row_id : '';
                    $sql = "SELECT ut_hr_employees. employee_row_id, ut_hr_employees. employee_id, ut_hr_employees. employee_name,  (SELECT DATE_FORMAT(first_login, '%H:%i') FROM ut_hr_staff_attendance_records WHERE ut_hr_employees.`employee_row_id` = ut_hr_staff_attendance_records.card_id AND ut_hr_staff_attendance_records.`attendance_date` = '$date_of_attendance' LIMIT 1) AS first_login, (SELECT DATE_FORMAT(last_logout, '%H:%i') FROM ut_hr_staff_attendance_records WHERE  ut_hr_employees.`employee_row_id` = ut_hr_staff_attendance_records.card_id AND ut_hr_staff_attendance_records.`attendance_date` = '$date_of_attendance' LIMIT 1) AS last_logout FROM ut_hr_employees $areaCond";
                    $arr[$area->title] =  DB::select($sql);
                }
            }
        }
       return  $arr;
    }

}