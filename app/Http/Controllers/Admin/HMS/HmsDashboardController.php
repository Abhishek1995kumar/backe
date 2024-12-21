<?php

namespace App\Http\Controllers\Admin\HMS;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HmsDashboardController extends Controller {
    public function hmsDashboard() {
        try {
            return view('admin.hms.hms-sub-module');

        } catch(Throwable $th) {

        }
    }
}
