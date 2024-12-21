<?php

namespace App\Models\Admin;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admins';

    protected $guard = 'admin';

    protected $guarded = [];

    protected $hidden = [
        'default_password',
        'password',
        'token',
    ];

    static public function getDashboard() {
        return Template::where('status',1)
                    ->where('deleted_at', NULL)
                    ->pluck('name')
                    ->toArray();
    }

    static public function getTableName() {
        $databaseTable = DB::select('SHOW TABLES');
        $details = [];
        foreach($databaseTable as $table) {
            $tableName = $table->Tables_in_ecomm;
            $recordCount = DB::table($tableName)->count();
            if($recordCount == 0) {
                $details[] = [
                    'table' => $tableName,
                    'has_records'=> false
                ];
                
            } else {
                $details[] = [
                    'table' => $tableName,
                    'has_records'=> true
                ];
            }
        }
        return $details;
    }

    // hasOne ka mtlb hota hai -- realted table
    // belongsTo ka mtlb hota hai -- foreign key table 

    public function getDesignation() {
        return $this->belongsTo(AdminDesignationMaster::class, 'designation_id');
    }

    public function getDepartment() {
        return $this->belongsTo(AdminDepartmentMaster::class, 'department_id');
    }

    public function getRole() {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    public function getSalary() {
        return $this->hasOne(AdminSalary::class);
    }

    public function getBank() {
        return $this->hasOne(AdminBankDetails::class);
    }

    public function getExperience() {
        return $this->hasMany(AdminExperience::class);
    }

}
