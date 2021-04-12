<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Helpers\SelectChefController;
use Carbon\Carbon;
use App\Meals;
use App\BookingSyncMeal;

class BookingController extends Controller
{
    
    public function createBooking(Request $request)
    { 
    	$booking=$request->data['booking'];
        $bookingRequest = new Request();
        $bookingRequest->setMethod('POST');
        $bookingRequest->request->add($booking);

        $validatorBooking = Validator::make($bookingRequest->all(), [
            'location_x' => 'required|numeric',
            'location_y' => 'required|numeric', 
            'location_z' => 'nullable|string',
            'cook_start_date' => 'required|date|date_format:Y-m-d|after:yesterday', 
            'Cook_start_time' => 'required|date_format:H:i', 
            'kitchen_id' => 'required|numeric|exists:kitchen_details,id', 
            'user_id' => 'required|numeric|exists:users,id',
        ],
        [
     	
        ]
    	);

        $meals=$request->data['meals'];
        //
        $mealsRequest=$this->getMealData($meals,$bookingRequest->cook_start_date, $bookingRequest->Cook_start_time);


 
    if ($validatorBooking->fails()) { 
                return response()->json(['errors'=>$validatorBooking->errors()->all()], 422);            
    }      
    
    $select_chef = new SelectChefController();
    $best_chef = $select_chef->choice(['meals'=>$mealsRequest['meal_id'], 'chefs'=>$mealsRequest['chefs_user_id']]);
    $best_chef = $best_chef['best_chef'];
    $user_id = $bookingRequest['user_id'];
    $key = md5(time());

    $booking=Booking::create([
        'location_x' => $bookingRequest['location_x'],
        'location_y' => $bookingRequest['location_y'],
        'location_z' => $bookingRequest['location_z'],
        'cook_start_date' =>$bookingRequest['cook_start_date'],
        'Cook_start_time' =>$bookingRequest['Cook_start_time'],
        'kitchen_id' =>$bookingRequest['kitchen_id'],
        'key' => $key,
        'user_id' => $user_id,
        'chef_id' => $best_chef,
    ]);
    foreach ($mealsRequest['meal_id'] as $key => $meal_id) {
        $this->createBookingMeal($mealsRequest,$key,$best_chef,$user_id,$booking->id,$booking->key);
    }


    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function createBookingMeal($mealsRequest,$key,$best_chef,$user_id,$booking_id,$booking_key)
    {

        $booking=BookingSyncMeal::create([
            'meal_id' => $mealsRequest['meal_id'][$key],
            'quantity' =>  $mealsRequest['quantity'][$key],
            'chef_id' =>  $mealsRequest['chefs_id'][$key],
            'chefs_user_id' =>  $mealsRequest['chefs_user_id'][$key],
            'meal_key' => null,
            'meal_fixed_price' => null,
            'meal_price_id' => null,
            'meal_price_currency_id' => null,
            'user_id' => $user_id,
            'booking_id' => $booking_id,
            'booking_key' => $booking_key,
            'key' => $booking_key,
        ]);

    }


    public function getKitchen($user_id)
    {

    	$data =  Kitchen::where('kitchen_details.user_id',$user_id)
                            ->with('userKitchen')
                            ->get();

    return response()->json($data, 200); 

    }
    public function getMealData($meals,$start_date, $start_time)
    {
        //we validate meals 
        $this->validateMeals($meals);
        $select_chef = new SelectChefController();
        $arry_chefs=[];
        $arry_chefs_user=[];
        foreach ($meals['meal_id'] as $key => $meal_id) {
            $meal = Meals::find($meal_id);
            if (isset($meal)) {
                $end_date = $this->getEndDate($start_date, $start_time, $meal->time_to);
                $bestExperience=$select_chef->bestExperience($meal_id,$start_date,$end_date);
                $arry_chefs[$key]=$bestExperience->id;
                $arry_chefs_user[$key]=$bestExperience->user_id;
            }

        }
        $meals['chefs_id']=$arry_chefs;
        $meals['chefs_user_id']=$arry_chefs_user;
        //dd($meals);
        return $meals;

    }

    public function validateMeals($meals)
    {
        $mealsRequest = new Request();
        $mealsRequest->setMethod('POST');
        $mealsRequest->request->add($meals);

        $validatorMeals = Validator::make($mealsRequest->all(), [
            'meal_id.*' => 'required|numeric|exists:meals,id',
            'quantity.*' => 'required|numeric', 
        ],
        [ 
        ]
        );


        if ($validatorMeals->fails()) { 
                    return response()->json(['errors'=>$validatorMeals->errors()->all()], 422);            
        }
    }

    public function getEndDate($start_date, $start_time,$time_to)
    {   
        $waiting = 0.5;//time shift 30min
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $start_date . ' '. $start_time)->toDateTimeString();
        //$end_date = $end_date->addHour($time_to+$waiting);

        return $end_date;
    }
}
