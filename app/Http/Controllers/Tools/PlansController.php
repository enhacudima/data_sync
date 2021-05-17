<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Subscription;

class PlansController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('role_or_permission:admin');

    }

    public function create(Request $request)
    {
        $formData=$request->data['formData'];
        $planDatID=$request->data['planDatID'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($formData);

        $input = $myRequest->all();

        if($planDatID){
            $result=Subscription::updatePlan($input,$planDatID);
        }else{
            $result=Subscription::createPlan($input,$planDatID);
        }


        return response()->json(['success'=>'Added new records.'], 200);
    }
    public function delete($id)
    {
        Subscription::deletePlan($id);

        return response()->json(['success'=>'Added deleted records.'], 200);
    }
    public function recoverPlan($id)
    {
        Subscription::recoverPlan($id);

        return response()->json(['success'=>'Added deleted records.'], 200);
    }

    public function createFeatures(Request $request){
        $formData=$request->data['formData'];
        $planDatID=$request->data['planDatID'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($formData);

        $input = $myRequest->all();

        $result=Subscription::createFeatures($input,$planDatID);

        return response()->json(['success'=>'Remove records.'], 200);
    }

}
