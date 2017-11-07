<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployeePerformanceComments extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'employee_performance_comment_row_id';

    public function userInfo()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

}
