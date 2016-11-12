<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Http\StatusCode;
use App\Http\Middleware\Constant;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;
    protected $statusCode;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, StatusCode $statusCode)
    {
        $this->auth = $auth;
        $this->statusCode = $statusCode;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if ($this->auth->guard($guard)->guest()) {
        //     return response()->json(['message' => 'Please login'], $this->statusCode->unauthorised);
        // }

        return $this->checkUser($request, $next);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function checkUser($request, Closure $next)
    {
        $token = $request->query('token');
            
            if (!empty($token)) {
                $appToken = User::where('api_token', '=', $token)
                    ->first();

                if (is_null($appToken)) {
                    return response()->json(['message' => 'User unauthorized due to invalid token'], $this->statusCode->unauthorised);
                }

                return $this->approveUser($request, $appToken, $next);
            }
    }
}
