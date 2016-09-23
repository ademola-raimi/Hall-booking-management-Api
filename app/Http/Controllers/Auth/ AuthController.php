<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Hash;
use Alert;
use App\User;
use Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    /**
     * This method post new users.
     *
     * @return new user
     */
    private function postRegister(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email'    => 'required',
            'password' => 'required',
            'access_level' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->name,
            'password'     => password_hash($request->password, PASSWORD_DEFAULT),
            'access_level' => $request->access_level,
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'api_token'    => $this->generateToken(),
            'avatar'       => $request->avatar,
            'provider'     => $request->provider,
            'provider_id'  => $request->provider_id,
        ]);

        if ($user) {
            return response()->json(['message' => 'Registration was successful'], 201);
        }

        return response()->json(['message' => 'Oops, Registration was Unsuccessful'], 400);
    }

    /**
     * Generate a token for user.
     *
     * @return string
     */
    public function generateToken()
    {
        $appSecret    = getenv('APP_SECRET');
        $jwtAlgorithm = getenv('JWT_ALGORITHM');
        $timeIssued   = time();
        $serverName   = getenv('SERVERNAME');
        $tokenId      = base64_encode(getenv('TOKENID'));
        $token        = [
            'iss'  => $serverName,    //Issuer: the server name
            'iat'  => $timeIssued,    // Issued at: time when the token was generated
            'jti'  => $tokenId,      // Json Token Id: an unique identifier for the token
            'nbf'  => $timeIssued,   //Not before time
            'exp'  => $timeIssued + 60 * 60 * 24 * 30 * 1 * 12, // expires in 30 days
        ];
        
        return JWT::encode($token, $appSecret, $jwtAlgorithm);
    }

     /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email'    => 'required',
        ]);

        $authStatus = (Auth::attempt(['username' => $email, 'password' => $password])) 

        if ($authStatus) {
            return response()->json(['message' => 'Authentication was successful'], 201);
        }
        return response()->json(['message' => 'Oops, Authentication was Unsuccessful'], 400);
    }
}
