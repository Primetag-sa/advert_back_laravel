<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = auth()->user();
        $user = \App\Models\User::first();
        if (count($user->activePlanSubscriptions()) == 0) {
            return response()->json(['error' => 'You must be subscribed to access this resource.'],401);
        }
        return $next($request);
    }
}
