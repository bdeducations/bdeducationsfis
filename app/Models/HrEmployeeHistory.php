<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployeeHistory extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'employee_history_row_id';

    public function employeeDepartment()
    {
        return $this->hasOne('App\Models\HrDepartment', 'department_row_id', 'department_row_id');
    }

	public function employeeDesignation()
    {
        return $this->hasOne('App\Models\HrDesignation', 'designation_row_id', 'designation_row_id');
    }
}
