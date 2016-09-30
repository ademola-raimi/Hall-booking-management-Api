<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;

class AdminMiddleware extends SuperAdminMiddleware
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

    public function readHandle()
    {
        return handle($request, $next);
    }

    public function checkUser($request, $appToken, $next)
    {
        if ($appToken->role_id <= Constant::ADMIN_USER) {
                return $next($request);
            }
            
        return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
    }
}
