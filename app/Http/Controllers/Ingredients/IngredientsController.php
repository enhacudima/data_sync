<?php

namespace App\Http\Controllers\Ingredients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ingredients;
use Auth;


class IngredientsController extends Controller
{
    


    public function getIngredients()
    {

    	$data =  Ingredients::get();

    return response()->json($data, 200); 

    }
}
