<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Attendence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
    //

    public function getAttendanceStatus(Request $request)
    {

        if (
            $request->admission_number != null && $request->startDate != null && $request->endDate != null
            && $request->startDate <= $request->endDate
        ) {
            $attendence = DB::table('attendences')
                ->select('attendences.*')
                ->where('admission_number', '=', $request->admission_number)
                ->whereBetween('Day', [$request->startDate, $request->endDate])
                ->get();
            error_log($attendence);
            $response = ['Attendence' => $attendence];
            return response($response, 200);
        } else {

            $response = ["message" => "Invalid Input Date Range "];
            return response($response, 422);
        }

    }
}
