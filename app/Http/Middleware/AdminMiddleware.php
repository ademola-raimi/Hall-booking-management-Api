<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;
use Illuminate\Contracts\Auth\Factory as Auth;

class AdminMiddleware extends Authenticate
{
    protected $statusCode;
    protected $handle;

    public function __construct(StatusCode $statusCode, Handle $handle, Auth $auth)
    {
        $this->statusCode = $statusCode;
        $this->handle = $handle;
        $this->auth = $auth;
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
        $token = $request->query('token');
            
            if (!empty($token)) {
                $appToken = User::where('api_token', '=', $token)
                    ->first();

                if (is_null($appToken)) {
                    return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
                }

                return $this->checkUser($request, $appToken, $next);
            }
    }

    public function checkUser($request, $appToken, $next)
    {
        if ($appToken->role_id <= Constant::ADMIN_USER) {
                return $next($request);
        }
  
        return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
    }
}
