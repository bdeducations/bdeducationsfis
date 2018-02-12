<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrOffdaySetting extends Model
{    
    protected $primaryKey = 'off_day_row_id';

    public function areaName()
    {
        return $this->hasOne('App\Models\Area', 'area_row_id', 'area_row_id');
    }
    public function institutionName()
    {
        return $this->hasOne('App\Models\HrInstitution','institution_row_id','institution_row_id');
    }
}
