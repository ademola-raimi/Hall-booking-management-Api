<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Alert;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\StatusCode;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $statusCode;

    public function __construct(StatusCode $statusCode)
    {
        $this->statusCode = $statusCode;
    }
    /**
     * This method post new users.
     *
     * @return new user
     */
    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email'    => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => password_hash($request->password, PASSWORD_DEFAULT),
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'api_token'    => $this->generateToken(),
            'avatar'       => $request->avatar,
        ]);

        if ($user) {
            return response()->json(['message' => 'Registration was successful'], $this->statusCode->created);
        }

        return response()->json(['message' => 'Oops, Registration was Unsuccessful'], $this->statusCode->unauthorised);
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
}
