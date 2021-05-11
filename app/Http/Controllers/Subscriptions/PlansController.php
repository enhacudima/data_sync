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


    public function getPlansFull(){
    $data = Subscription::getPlansFull();
    return response()->json($data, 200);
    }

    public function getFeatureValue($subscription,$feature){
        $data = Subscription::getFeatureValue($subscription,$feature);
        return response()->json($data, 200);
    }
    public function creatSubscription($plan,$subscription, $user){
        $data = Subscription::creatSubscription($plan,$subscription, $user);
    }

    public function  changePlanSubscription($plan, $user){
        $subscription = app('rinvex.subscriptions.plan_subscription')->latest()->first();
        $subscription =$subscription->id;
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


    public function getInvoice(){
        $user = Auth::user()->id;
        $data = Subscription::getInvoice($user);
        return response()->json($data, 200);
    }

    public function getInvoices(){
        $data = Subscription::getInvoices();
        return response()->json($data, 200);
    }

    public function getUserPlan($user){
        $data = Subscription::getUserPlan($user);
        return response()->json($data, 200);

    }

    public function applyInvoce(Request $request){
        $applyData=$request->data['applyData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($applyData);

        $validator = Validator::make($myRequest->all(), [
            'operation' => 'required|string|max:50',
            'invoice_id' => 'required',
            'notes' =>'required_if:operation,==,Not Apply',
            'amount' =>'required_if:operation,!=,Not Apply|numeric'
        ],
        [

        ]
    	);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
        $data = Subscription::find($myRequest['invoice_id']);

        if (!isset($data)) {
            return response()->json(['errors'=>["This invoice does not exist."]], 422);
        }
        if ($data->status != 1) {
            return response()->json(['errors'=>["You cannot change this invoice because is not pending."]], 422);
        }


        $plan = app('rinvex.subscriptions.plan')->find($data->plan_id);
        $plan_id = $plan->id;
        $subscription_title=$plan->slug;
        $user=$data->user_id;
        $check_plan = Subscription::getUserSubscriptions($user,$plan_id);
        $check_amount = $plan->price == $myRequest->amount;

        /*$subscription = app('rinvex.subscriptions.plan_subscription')
        ->where('subscriber_id',$user)
        ->where('plan_id',$plan_id)
        ->first();*/

        switch ($myRequest['operation']) {
            case 'Renew':
                if(!$check_plan){
                    return response()->json(['errors'=>["You cannot renew subscription because is not existe or is canceled."]], 422);
                }
                $type = "renew";
                $this->renewSubscription($type,$subscription->slug,$user);
                $this->update_invoice($data,$myRequest,2);
                break;
            case 'New':
                if($check_plan){
                    return response()->json(['errors'=>["You cannot create new subscription because is ready existe."]], 422);
                }
                $this->creatSubscription($plan_id,$subscription_title, $user);
                $this->update_invoice($data,$myRequest,2);
                break;
            case 'Change':
                if(!isset($plan)){
                    return response()->json(['errors'=>["You cannot change subscription because don't existe any subscription."]], 422);
                }
                if($check_plan){
                    return response()->json(['errors'=>["You cannot change subscription because is ready existe."]], 422);
                }
                $this->changePlanSubscription($plan_id, $user);
                $this->update_invoice($data,$myRequest,2);
                break;
            case 'Not Apply':
                $this->update_invoice($data,$myRequest,3);
                break;

            default:
                # code...
                break;
        }
        return response()->json(['success'=>'Added new records.'], 200);
    }

    public function update_invoice($data,$myRequest,$status){
        $reference = time() . '-' . Auth::user()->id;

        $data["reference"] = $reference;
        $data["notes"] = $myRequest['notes'];
        $data["operation"] = $myRequest['operation'];
        $data["amount"] = $myRequest['amount'];
        $data["status"] = $status;
        $data->save();
    }

    public function checkAnyUserPlan($user){
        $data=$data = Subscription::getUserPlan($user);

        $checked = false;
        foreach ($data as $key => $value) {
            $data = Subscription::checkAnyUserPlan($value->plan_id,$user);
            if($data){
               $checked =$data;
               break;
            }
        }
        return $checked;
    }

}

