<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;

class AdminMiddleware extends Authenticate
{
    protected $statusCode;
    protected $handle;

    public function __construct(StatusCode $statusCode, Handle $handle)
    {
        $this->statusCode = $statusCode;
        $this->handle = $handle;
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
        return $this->handle->handle($request, $next);
    }

    public function checkUser($request, $appToken, $next)
    {
        if ($appToken->role_id <= Constant::ADMIN_USER) {
                return $next($request);
        }
  
        return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
    }
}
