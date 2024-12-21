<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
    use AuthorizesRequests, ValidatesRequests;

    public function __construct() {
        $this->middleware(function($request, $next) {
            try {
                return $next($request);
            } catch (Throwable $exception) {
                // Log the error with the controller class name
                errorLog($exception->getMessage(), get_class($this));
                throw $exception;
            }
        });
    }
}
