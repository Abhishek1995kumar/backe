<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model {
    use HasFactory, SoftDeletes;
    protected $guard = 'admin';
    protected $table = 'admin_module';
    protected $guarded = [];

    public function subPermission() {
        return $this->hasMany(SubPermission::class, 'module_id');
    }

    public function permissionMappingWithRoleAndPermissionMapping() {
        return $this->hasMany(RoleAndPermissionMapping::class, 'module_id');
    }

    public function getModuleDetails() {
        return self::where('status', 1)
                ->where('deleted_at', null)
                ->orderBy('order')
                ->get();
    }
}
