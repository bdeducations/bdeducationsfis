<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectHead extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $table = 'project_heads';
    protected $primaryKey = 'project_head_row_id';
}
