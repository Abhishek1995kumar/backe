<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleAndPermissionMapping extends Model {
    // Role and Permission Mappings -- use table admin_module_mappings
    use HasFactory, SoftDeletes;

    protected $table = 'admin_module_mappings';

    protected $guarded = [];

    public function roles() {
        return $this->belongsTo(AdminRole::class);
    }

    public function parentModuleRelation() {
        return $this->belongsTo(Permission::class);
    }

    public function subModuleRelation() {
        return $this->belongsTo(SubPermission::class);
    }

    public function childModuleRelation() {
        return $this->belongsTo(ChildPermission::class);
    }

}
