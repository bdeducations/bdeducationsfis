<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrInstitution extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'institution_row_id';

    public function sector_info() {
    	  return $this->hasOne('App\Models\HrDepartment','department_row_id','department_row_id');
    }
    public function area_name() {
    	  return $this->hasOne('App\Models\Area','area_row_id','area_row_id');
    }
}
