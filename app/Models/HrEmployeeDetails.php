<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployeeDetails extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'employee_details_row_id';
}
