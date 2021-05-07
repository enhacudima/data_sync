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
}

