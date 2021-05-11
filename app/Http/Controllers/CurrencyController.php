<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{

    public function getCurrency()
    {
    	$data=Currency::all();
    	return response()->json($data, 200);
    }


    public function getCurrencyArr ()
    {
        $data=Currency::select('currency','id','entity','alphabetic_code')->orderby('alphabetic_code','asc')->get()->toArray();
    	return response()->json($data, 200);
    }
}
