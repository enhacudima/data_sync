<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
use App\CountryStates;
use App\ProvinceStates;
use App\Http\Controllers\Helpers\LocationController;
use App\Http\Controllers\Tools\RolesPermissionsController;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('details');

    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function register(Request $request)
    {
    	$userData=$request->data['userData'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($userData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
            'dataBrith' => 'nullable|date|date_format:Y-m-d',
            'phone1'=>'required|numeric',
            'prefix_phone_1'=>'required|numeric', //removed
            //'type'=>'required|numeric', //removed
            'terms_conditions' =>'required|accepted',
        ],
        [

        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

    $key = md5(time()).'U';
    $input = $myRequest->all();

        $input['userName'] = strtok($input['email'], '@');
        $input['password'] = bcrypt($input['password']);
        $input['key'] = $key;
        $user = User::create($input);
        $location= new LocationController($user->id,$input['prefix_phone_1'], null, null, null);

        $user->sendEmailVerificationNotification();

        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        //difine user role for basic
        $role = new RolesPermissionsController();
        if($user){
            $role->setUserRole("basic", $user->key);
        }


    return response()->json(['success'=>'Added new records.'], 200);
    }
}
