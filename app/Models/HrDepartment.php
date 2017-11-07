<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrDepartment extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'department_row_id';
}
