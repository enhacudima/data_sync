<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Subscription;


class PlansController extends Controller{


    public function __construct()
    {
        $this->middleware('auth:api');
    }



    public function create(Request $request){
        Subscription::make();
    }

    public function getDetails($plan,$type){
        $data = Subscription::getPlanDetails($plan,$type);
        return response()->json($data, 200);
    }


    public function getFeatureValue($subscription,$feature){
        $data = Subscription::getFeatureValue($subscription,$feature);
        return response()->json($data, 200);
    }
    public function creatSubscription($plan,$subscription, $user){
        $data = Subscription::creatSubscription($plan,$subscription, $user);
    }

    public function  changePlanSubscription($plan, $subscription){
        $data = Subscription::changePlanSubscription($plan, $subscription);
    }

    public function subscriptionFeatureUsage($type,$subscription,$feature,$user){
        $data = Subscription::subscriptionFeatureUsage($type,$subscription,$feature,$user);
         return response()->json($data, 200);
    }

    public function recordFeatureUsage($type,$subscription,$feature,$user,$value){
        $data = Subscription::recordFeatureUsage($type,$subscription,$feature,$user,$value);
    }
    public function recordFeatureCleare($subscription,$user){
        $data = Subscription::recordFeaturecleare($subscription,$user);
    }
    public function checkSubscriptionStatus($type,$subscription,$planId,$user){
        $data = Subscription::checkSubscriptionStatus($type,$subscription,$planId,$user);
        return response()->json($data, 200);
    }
    public function renewSubscription($type,$subscription,$user){
        $data = Subscription::renewSubscription($type,$subscription,$user);
    }

    public function getPlans(){
        $data = Subscription::getPlans();
        return response()->json($data, 200);
    }


        public function preSubscription(Request $request)
    {
        $roleData=$request->data['roleData'];
        $roleDatID=$request->data['roleDatID'];

        $file_id=null;
        if(isset($roleData['file']['file_id'])){
            $file_id = $roleData['file']['file_id'];
        }

        $roleData['pdf_file'] = $file_id;

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($roleData);

        $validator = Validator::make($myRequest->all(), [
            'plans' => 'required|numeric|max:50',
            'pdf_file' => 'required',
        ],
        [

        ]
    	);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }

        $input = $myRequest->all();
        $input['user_id'] = Auth::user()->id;
        $input['key'] = md5(time());


            $subscription=Subscription::Create(
            	[
                    'user_id'=> $input['user_id'],
                    'plan_id'=> $input['plans'],
                    'pdf_file'=> $input['pdf_file'],
                    'key'=> $input['key']
            	]
            );


            $file = new FilesController;
            $file_id = $myRequest['pdf_file'];
            $file->useFile($file_id,$subscription->id, 'plan_invoice', 0);



        return response()->json(['success'=>'Added new records.'], 200);
    }


    public function getInvoices(){
        $user = Auth::user()->id;
        $data = Subscription::getInvoices($user);
        return response()->json($data, 200);
    }


}

