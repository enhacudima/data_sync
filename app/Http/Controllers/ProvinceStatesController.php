<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProvinceStates;

class ProvinceStatesController extends Controller
{
    
    public function getCountry()
    {
    	$country=ProvinceStates::groupby("country_name")->pluck("country_name");
    	$data=ProvinceStates::all();
    	return response()->json(['all'=>$data,'country'=>$country], 200); 
    }
}
