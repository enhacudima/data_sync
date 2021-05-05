<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class PlansController extends Controller{


    public function create(Request $request){
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

}

