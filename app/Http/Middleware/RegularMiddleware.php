<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class RegularMiddleware
{
    /**
     * declaring constant signifying to compare to the role_id
     *
    */
    const REGULAR_USER       = 1;
    const ADMIN_USER         = 2;
    const SUPER_ADMIN_USER   = 3;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->query('token');

        if (!empty($token)) {
            $appToken = User::where('api_token', '=', $token)
                ->first();

            if (is_null($appToken)) {
                return response()->json(['message' => 'User unauthorized due to invalid token'], 401);
            }

            if ($appToken->access_level == self::REGULAR_USER || $appToken->access_level == self::ADMIN_USER || $appToken->access_level == self::SUPER_ADMIN_USER) {
                return $next($request);
            }

            return response()->json(['message' => 'User unauthorized due to limited token'], 401);
        }

        return response()->json(['message' => 'User unauthorized due to empty token'], 401);
    }
}
