<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminExperience extends Model {
    use HasFactory, SoftDeletes;

    protected $guard = 'admin';

    protected $table = 'admin_experiences';

    protected $guarded = [];

    public function getAdminExperience() {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

}
