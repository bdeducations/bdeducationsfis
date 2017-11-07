<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrDesignation extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'designation_row_id';

    public function department_info() {
    	  return $this->hasOne('App\Models\HrDepartment', 'department_row_id', 'department_row_id');
    }
}
