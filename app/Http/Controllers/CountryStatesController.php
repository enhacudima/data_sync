<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CountryStates;

class CountryStatesController extends Controller
{
    
    public function getCountryStates()
    {
    	$data=CountryStates::select('phone')->orderby('internet','asc')->get()->toArray();
    	return response()->json($data, 200); 
    }
}
