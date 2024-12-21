<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivityLog extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'user_login_details';

    protected $guarded = [];

    const SUCCESS = 1;
    const FAILED = 2;
    const PROCESSING = 3;
    const JOB_FAILED = 4;
    const EMPLOYEE_ADD = 5;
    const EMPLOYEE_DELETE = 6;
    const EMPLOYEE_UPDATE = 7;

    
}
