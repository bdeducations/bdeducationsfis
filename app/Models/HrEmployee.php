<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'employee_row_id';

    public function areaName()
    {
        return $this->hasOne('App\Models\Area', 'area_row_id', 'area_row_id');
    }
    public function employeeInstitution()
    {
        return $this->hasOne('App\Models\HrInstitution', 'institution_row_id', 'institution_row_id');
    }

    public function employeeDetails()
    {
        return $this->hasOne('App\Models\HrEmployeeDetails', 'employee_row_id', 'employee_row_id');
    }
	
	public function employeeDepartment()
    {
        return $this->hasOne('App\Models\HrDepartment', 'department_row_id', 'department_row_id');
    }

	public function employeeDesignation()
    {
        return $this->hasOne('App\Models\HrDesignation', 'designation_row_id', 'designation_row_id');
    }
}
