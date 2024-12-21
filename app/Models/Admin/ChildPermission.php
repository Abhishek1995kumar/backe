<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildPermission extends Model {
    use HasFactory, SoftDeletes;
    protected $guard = 'admin';
    protected $table = 'admin_child_module';
    protected $guarded = [];

    public function subModuleFromChild() {
        return $this->belongsTo(SubPermission::class, 'sub_module_id', 'id');
    }

    public function subModuleFromChild() {
        return $this->belongsTo(SubPermission::class, 'sub_module_id', 'id');
    }


}
