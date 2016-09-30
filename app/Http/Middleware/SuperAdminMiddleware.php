<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;

class SuperAdminMiddleware
{
    protected $statusCode;

    public function __construct(StatusCode $statusCode)
    {
        $this->statusCode = $statusCode;
    }
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
                return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
            }

            return $this->checkUser($request, $appToken, $next);
        }

        return response()->json(['message' => 'User unauthorized due to empty token'], $this->statusCode->unauthorised);
    }

    public function checkUser($request, $appToken, $next)
    {
        if ($appToken->role_id === Constant::SUPER_ADMIN_USER) {
                return $next($request);
            }

        return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
    }
}
