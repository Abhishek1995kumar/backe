<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPermission extends Model {
    use HasFactory, SoftDeletes;
    protected $guard = 'admin';
    protected $table = 'admin_sub_module';
    protected $guarded = [];

    public function parentModuleFromSub() {
        return $this->belongsTo(Permission::class, 'module_id', 'id');

    }

    public function childModuleFromSub() {
        return $this->hasMany(ChildPermission::class, 'sub_module_id', 'id');
    }

    
    public function subRoleSubPermissionMapping() {
        return $this->belongsToMany(RoleAndPermissionMapping::class, 'module_id');
    }
}
