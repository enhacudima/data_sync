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
            'dataBrith' => 'required|date|date_format:Y-m-d|before:18 years ago',
            'phone1'=>'required|numeric|unique:users,phone1',
            //'prefix_phone_1'=>'required', //removed
            //'type'=>'required|numeric', //removed
            'terms_conditions' =>'required|accepted',
        ],
        [

        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }
    //$country = CountryStates::find($userData['prefix_phone_1']);
    // $province = ProvinceStates::where('state_2_code',$country->internet)->first();
    $key = md5(time()).'U';
    $input = $myRequest->all();

    $phone1=$input['phone1'];

    if(isset($userData['prefix_phone_1'])){
        $prefix_phone_1 = $input['prefix_phone_1']['phone'];
        $input['phone1']= $prefix_phone_1.$phone1;
    }else{
        $prefix_phone_1 = substr($phone1, 0, -9);
    }

        $input['userName'] = strtok($input['email'], '@');
        $input['password'] = bcrypt($input['password']);
        $input['prefix_phone_1'] = '+'.$prefix_phone_1;
        //$input['prefix_id'] = $userData['prefix_phone_1'];
        $input['key'] = $key;
        $user = User::create($input);
        $location= new LocationController($user->id,$prefix_phone_1, null, null, null);

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
