<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;

class EnsureEmailsVerified {
    public function handle(Request $request, Closure $next, ...$guards) {
        if(!$request->user() || ($request->user() instanceof MustVerifyEmail && ! $request->user()->hasVerifiedEmail() ) ) {
            abort(403, 'Your email address is not verified.');
        }
        return $next($request);
    }
}
