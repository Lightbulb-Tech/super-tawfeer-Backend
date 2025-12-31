<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlockedUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (@Auth::guard('api')->user()->is_blocked == 0) {
            return $next($request);
        } else {
            return response()->json(['message'=>'blocked'],423);
        }
    }
}
