<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Cookie;
use App\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function forgotPassword(Request $request)
    {
        $arr=null;
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }  else {
            try {
                $response = Password::sendResetLink($request->only('email')/*, function (Message $message) {
                    $message->subject($this->getEmailSubject());
                }*/);
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:
                        return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            }
        }
        return \Response::json($arr);
    }


    public function reset(Request $request){
            $input = $request->only('email','token','password', 'password_confirmation');
            $validator = Validator::make($input, [
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
            ]);

             if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }


                $response = Password::reset($input, function ($user, $password) {
                    $user->password = bcrypt($password);
                    $user->save();
                });

                switch ($response) {
                    case Password::INVALID_TOKEN:
                        return response()->json(['errors'=>[trans($response)]], 422);
                    case Password::INVALID_USER:
                        return response()->json(['errors'=>[trans($response)]], 422);
                }


                 return response()->json(['success'=>'Password reseted successfully.'], 200);
    }

}
