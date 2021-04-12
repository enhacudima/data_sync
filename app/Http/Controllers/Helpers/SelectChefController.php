<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Meals;
use App\ChefCalendar;
use App\CvChefeV;

class SelectChefController extends Controller
{
    

    public function choice($chefs_meal)
    {
        $best_chef = $this->mode($chefs_meal['chefs']);
        $out_of_meal = $this->out($chefs_meal, $best_chef);
        return ['best_chef'=>$best_chef, 'out_of_meal' => $out_of_meal];
    }

    public function mode($chefs){
        $valueArray = $chefs;
        $values = array_count_values($valueArray); 
        $mode = array_search(max($values), $values);
        return $mode;
    }

    public function out($chejs_meal, $best_chef){
        $out_meals=[];
        foreach ($chejs_meal['chefs'] as $key => $chef) {
            if ($chef != $best_chef) {
                array_push($out_meals,$chejs_meal['meals'][$key]);
            }
        }
        return $out_meals;
    }

    public function bestExperience($meal,$start_date,$end_date)
    {
        $getMeal=Meals::find($meal);
        $experence=$getMeal->experience_id;
        $getMeal=$getMeal->mealChefs;
        $end=3;//numbers of trying 
        for ($i=0; $i < $end; $i++) {
            if (isset($experence)) {
               $randomChefe=CvChefeV::where('exy_id',$experence)->inRandomOrder()->first();//my chef
            }
            if (isset($randomChefe)) {//check is he is availeble 
                $ChefCalendar=ChefCalendar::where('id',$randomChefe->id)
                                            ->where('start_date','<=',$start_date)
                                            ->where('end_date','>=',$end_date)
                                            ->first();
            }
            if (!isset($ChefCalendar)) {
                break;//break if is availeble 
            }
        }
        
        return $randomChefe;


    }
}
