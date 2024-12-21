<?php

namespace App\Models\Admin;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminRole extends Model {
    use HasFactory, SoftDeletes;
    protected $guard = 'admin';
    protected $table = 'admin_roles';
    protected $guarded = [];

    public function getRoleDetails($data=null) {
        try{
            if($data) {
                return Self::where('id', $data)->where('status', 1)->first();

            } else{
                return Self::where('status', 1)->get();
            }
        } catch(Throwable $th) {
            throw $th;
            return Log::info([$th->getMessage(), $th->getTraceAsString()]);

        }
    }

    public function roleAndPermissionMapping() {
        return $this->belongsToMany(RoleAndPermissionMapping::class, 'admin_module_mappings');
    }

}
