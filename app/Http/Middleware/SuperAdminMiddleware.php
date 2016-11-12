<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;
use Illuminate\Contracts\Auth\Factory as Auth;

class SuperAdminMiddleware extends Authenticate
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
    public function readHandle($request, Closure $next)
    {
        return $this->handle($request, $next);
    }

    public function approveUser($request, $appToken, $next)
    {
        if ($appToken->role_id === Constant::SUPER_ADMIN_USER) {
                return $next($request);
        }

        return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
    }
}
