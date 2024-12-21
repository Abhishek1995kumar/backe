<?php

namespace App\Models\Admin;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminDesignationMaster extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'admin_designation_masters';

    protected $guarded = [];

    public function getDesignationDetails($data=null) {
        try{
            if($data) {
                return Self::where('id', $data)->where('status', 1)->first();

            } else{
                return Self::where('status', 1)->get();
            }

        } catch(Throwable $th) {
            return Log::info([$th->getMessage(), $th->getTraceAsString()]);

        }
    }
}
