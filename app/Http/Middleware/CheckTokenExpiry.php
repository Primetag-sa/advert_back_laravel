<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken && $accessToken->expires_at && $accessToken->expires_at->isPast()) {
                return response()->json(['message' => 'Token expired'], 401);
            }
        }
        return $next($request);
    }
}
