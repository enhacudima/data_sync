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
use App\Http\Controllers\Helpers\BackUpUserController;
use Hash;

class EditUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

    }


    public function userEdit(Request $request)
    {
    	$userData=$request->data['userData'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($userData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dataBrith' => 'required|date|date_format:Y-m-d|before:18 years ago',
            'phone1'=>'required|numeric|digits:9|unique:users,phone1,'.Auth::user()->id.',id',
            'isEditing'=>'required',
            'fullAddress'=>'nullable|string|min:12|max:255',
        ],
        [

        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }

    $input = $myRequest->all();

    $phone1=$input['phone1'];

    if(isset($userData['prefix_phone_1']['phone'])){
        $prefix_phone_1 = $input['prefix_phone_1']['phone'];
        $input['phone1']= $prefix_phone_1.$phone1;
    }
    elseif(isset($userData['prefix_phone_1'])){
        $prefix_phone_1 = $input['prefix_phone_1'];
        $input['phone1']= $prefix_phone_1.$phone1;
    }else{
        $prefix_phone_1 = substr($phone1, 0, -9);
    }

        $input['prefix_phone_1'] = '+'.$prefix_phone_1;

        $backup= new BackUpUserController(Auth::user()->key);
        $user = User::where('id',Auth::user()->id)->update([
            'name'=>$input['name'],
            'lastName' => $input['lastName'],
            'dataBrith' => $input['dataBrith'],
            'prefix_phone_1' => $input['prefix_phone_1'],
            'phone1'=>$input['phone1'],
            'fullAddress'=>$input['fullAddress'],
        ]);

        $location= new LocationController(Auth::user()->id,$prefix_phone_1, null, null, null);
        if( $input['isEditing']){
            $message=$this->changePassword($myRequest);
            return ($message);
        }else{
         return response()->json(['success'=>'Updated records.'], 200);
        }


    }


    public function changePassword($request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
        );

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        } else {
            try {
                if ((Hash::check($request->old_password, Auth::user()->password)) == false) {
                    return response()->json(['errors'=>['Check your old password.']], 422);
                } else if ((Hash::check($request->password, Auth::user()->password)) == true) {
                    return response()->json(['errors'=>['Please enter a password which is not similar then current password.']], 422);
                } else {
                    User::where('id', $userid)->update(['password' => bcrypt($input['password'])]);
                    return response()->json(['success'=>['Password updated successfully.']], 200);
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    return response()->json(['errors'=>[$ex->errorInfo[2]]], 422);
                } else {
                    return response()->json(['errors'=>[$ex->getMessage()]], 422);
                }
            }
        }
        return response()->json(['success'=>'Updated records.'], 200);
    }


}
