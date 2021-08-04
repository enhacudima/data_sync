<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Cookie;
use App\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    protected function hasTooManyLoginAttempts(Request $request)
    {

       $maxLoginAttempts = 3;
       $lockoutTime = 2; // In minutes

       return $this->limiter()->tooManyAttempts(
           $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
       );
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if(!$user->email_verified_at){
                return response()->json(['error'=>'Please Verify Email','id'=>$user->id,'description' => 'Você pode clicar em reenviar para verificar seu e-mail.' ,'message'=>'Verificação de e-mail', 'url' => 'email/resend', 'button' => 'Reenviar link' ], 403);
            };
            $token =  $user->createToken('Personal Access Token')->accessToken;
            $cookie = $this->getCookieDetails($token);
            $user_2 = clone $user;
            return response()
                ->json([
                    'logged_in_user' => $user,
                    'token' => $token,
                    'permissions' =>$user_2->getPermissionsAttribute(),
                ], 200)
                ->cookie($cookie['name'], $cookie['value'], $cookie['minutes'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly'], $cookie['samesite']);
        } else {
            $this->incrementLoginAttempts($request);
            return response()->json(
                ['errors' => 'Essas credenciais não correspondem aos nossos registros.'], 422);
        }
    }
    private function getCookieDetails($token)
    {
        return [
            'name' => '_token',
            'value' => $token,
            'minutes' => 1440,
            'path' => null,
            'domain' => null,
            'secure' => true, // for production
            //'secure' => null, // for localhost
            'httponly' => true,
            'samesite' => true,
        ];
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $cookie = Cookie::forget('_token');
        return response()->json([
            'message' => 'successful-logout'
        ])->withCookie($cookie);
    }

    public function logoutAll(Request $request)
    {

        $accessToken = auth()->user()->token();
        $token= $request->user()->tokens->find($accessToken);
        $token->revoke();

        $cookie = Cookie::forget('_token');
        return response()->json([
            'message' => 'successful-logout'
        ])->withCookie($cookie);
    }
}
