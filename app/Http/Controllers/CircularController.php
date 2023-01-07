<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CircularController extends Controller
{
    //

    
    public function getCircularMetaData()
    {
         
            $CircularmetaData= DB::table('circular__meta_data')->get();
            $response = ['Attendence' => $CircularmetaData];
            return response($response, 200);
    
    }


    public function getCircularDetailsById(Request $request)
    {
     
        if($request->circular_id!=null)
        {
       $CircularDetails= DB::table('student_circular_info')
       ->where('id', '=', $request->circular_id)
       ->get();
        }else{
            $response = ["message" => "Input Data Cannot Be Null"];
            return response($response, 422);

        }
       if(sizeof($CircularDetails)!=null)
       {
        $response = ['CircularDetails' => $CircularDetails];
        return response($response, 200);

       }
       else{
             
        $response = ["message" => "No Circulars present for this input Value"];
        return response($response, 422);

       }


    }
    
    public function getStudentsCircular(Request $request)
    {

        if($request->Class_id!=null&&$request->circular_type!=null)
        {
       $CircularDetails= DB::table('student_circular_info')
       ->where('Class_id', '=', $request->Class_id)
       ->where('Circular_Type','=',$request->circular_type)
       ->get();
        }else{
            $response = ["message" => "Input Data Cannot Be Null"];
            return response($response, 422);

        }
       if(sizeof($CircularDetails)!=null)
       {
        $response = ['Attendence' => $CircularDetails];
        return response($response, 200);

       }
       else{
             
        $response = ["message" => "No Circulars present for this input Value"];
        return response($response, 422);

       }

    }
}
