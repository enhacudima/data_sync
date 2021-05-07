<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Rinvex\Subscriptions\Models\PlanFeature;
use App\User;

class Subscription extends Model
{
    use HasFactory;
    use HasSubscriptions;




    public static function make(){
        $plan = app('rinvex.subscriptions.plan')->create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 9.99,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'USD',
        ]);

        // Create multiple plan features at once
        $plan->features()->saveMany([
            new PlanFeature(['name' => 'listings', 'value' => 50, 'sort_order' => 1]),
            new PlanFeature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            new PlanFeature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);
    }

    public static function getPlanDetails($plan,$type){
        $plan = app('rinvex.subscriptions.plan')->find($plan);
        switch ($type) {
            case 'features':
                // Get all plan features
                $deteils=$plan->features;
                break;
            case 'options':
                // Get all plan subscriptions
                $deteils=$plan->subscriptions;
                break;
            case 'free':
                // Check if the plan is free
                $deteils=$plan->isFree;
                break;
            case 'trial':
                // Check if the plan has trial period
                $deteils=$plan->hasTrial;
                break;
            case 'grace':
                // Check if the plan has grace period
                $deteils=$plan->hasGrace;
                break;

            default:
                $deteils=null;
                break;
        }

        return $deteils;
    }


    public static function getFeatureValue($subscription,$feature){
        // Get feature value through the subscription instance
        $amountOfFeatures = app('rinvex.subscriptions.plan_subscription')->find($subscription)->getFeatureValue($feature);

        return $amountOfFeatures;
    }

    public static function creatSubscription($plan,$subscription,$user){
        $user = User::find($user);
        $plan = app('rinvex.subscriptions.plan')->find($plan);
        $user->newSubscription($subscription, $plan);

    }

    public static function changePlanSubscription($plan, $subscription){
        $plan = app('rinvex.subscriptions.plan')->find($plan);
        $subscription = app('rinvex.subscriptions.plan_subscription')->find($subscription);
        // Change subscription plan
        $subscription->changePlan($plan);
    }

    public static function subscriptionFeatureUsage($type,$subscription,$feature,$user){
        $user = User::find($user);

        switch ($type) {
            case 'canUseFeature':
                //determine the usage and ability of a particular feature in the user subscription,
                $result = $user->subscription($subscription)->canUseFeature($feature);
                break;
            case 'featureUsage':
                //returns how many times the user has used a particular feature
                $result = $user->subscription($subscription)->getFeatureUsage($feature);
                break;
            case 'featureRemainings':
                //returns available uses for a particular feature
                $result = $user->subscription($subscription)->getFeatureRemainings($feature);
                break;
            case 'featureValue':
                //returns the feature value
                $result = $user->subscription($subscription)->getFeatureValue($feature);
                break;

            default:
                $result = null;
                break;

                return $result;
        }
    }
    public static function recordFeatureUsage($type,$subscription,$feature,$user,$value){
        $user = User::find($user);

        switch ($type) {
            case 'usage':
                $user->subscription($subscription)->recordFeatureUsage($feature, $value);
                break;
            case 'reduce':
                //substract a given quantity
                $user->subscription($subscription)->reduceFeatureUsage($feature, $value);
                break;

            default:
                # code...
                break;
        }

    }

    public static function recordFeaturecleare($subscription,$user){
        $user = User::find($user);
        $user->subscription($subscription)->usage()->delete();
    }


    public static function checkSubscriptionStatus($type,$subscription,$planId,$user){
        $user = User::find($user);

         switch ($type) {
             case 'active':
                 $resut = $user->subscription($subscription)->active();
                 break;
             case 'canceled':
                 $resut = $user->subscription($subscription)->canceled();
                 break;
             case 'ended':
                 $resut = $user->subscription($subscription)->ended();
                 break;
             case 'onTrial':
                 $resut = $user->subscription($subscription)->onTrial();
                 break;

             case 'subscribedTo':
                 $resut = $user->subscribedTo($planId);
                 break;

             default:

                 break;
         }

         return $resut;
    }

    public static function renewSubscription($type,$subscription,$user){
        $user = User::find($user);
        switch ($type) {
            case 'renew':
                $user->subscription($subscription)->renew();
                break;
            case 'cancel':
                $user->subscription($subscription)->cancel();
                break;

            default:
                $user->subscription($subscription)->cancel(true);
                break;
        }
    }
}
