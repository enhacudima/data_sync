<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemoveRelectionController extends Controller
{
    public $relaction;
    public $subRelaction;
    public $subRelaField;
    public $newArray;
    public $model;
    public $dataRemove;

    public function __construct($model,array $dataRemove)
    {
        $this->model = $model; 
        $this->dataRemove = $dataRemove;  
    }

    
    public function readRelections()
    {   $newData=[];


        foreach($this->model as $key => $value){
            
            $simpData=$value;
            $newRelaction = null;
            foreach($this->dataRemove as $key => $remove){
                $this->relaction = $remove['relaction'];
                $this->subRelaction = $remove['subRelaction'];
                $this->subRelaField =$remove['subRelaField'];
                $this->newArray = $remove['newArray'];
                if(isset($this->relaction)){
                    if($this->relaction != null){
                    $newRelaction=$this->removeRelections($value[$this->relaction],$this->subRelaction,$this->subRelaField);
                    unset($simpData[$this->relaction]);
                    }
                }else{
                    $newRelaction=$this->removeSubRelections($value[$this->subRelaction],$this->subRelaField);
                    unset($simpData[$this->subRelaction]);
                }

                
                $simpData[$this->newArray]=$newRelaction;
                $this->relaction = null;
                $newRelaction = null;
            }


            array_push($newData,$simpData);
            
        }
        return $newData;
        
        
    }
    public $newSubRelaction;
    public $newsubRelaField;
    public function removeRelections($data,$subRelaction,$subRelaField)
    {   
        $this->newSubRelaction=$subRelaction;
        $this->newsubRelaField=$subRelaField;
        $retData = array_map(function($obj){
            return $obj[$this->newSubRelaction][$this->newsubRelaField]; 
        }, $data);
        return $retData;
    }
    
    public function removeSubRelections($data,$subRelaField)
    {   
        $this->newsubRelaField=$subRelaField;
        $retData = array_map(function($obj){
            return $obj[$this->newsubRelaField]; 
        }, $data);

        return $retData;
    }

    

}
