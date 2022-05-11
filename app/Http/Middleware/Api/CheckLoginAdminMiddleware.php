<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class CheckLoginAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth()->user()->role_id == config('auth.roles.admin')) {
            return $next($request);
        } else {
            return response()->json([
                'messasge' => __('messages.you do not have access'),
            ], 401);
        }
    }
}
