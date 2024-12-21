<?php

namespace App\Models\Admin;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminDepartmentMaster extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'admin_department_masters';

    protected $guarded = [];

    public static function getActiveDepartments() {
        return self::where('status', 1)->get(); 
    }

    public function employeesDepartment() {
        return $this->hasMany(Admin::class, 'department_id', 'id');
    }
}
