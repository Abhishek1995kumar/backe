<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication {
    public function handle(Request $request, Closure $next) : Response {
        if(!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access this route');
        }
        return $next($request);
    }
}
