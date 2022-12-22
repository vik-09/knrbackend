<?php

namespace App\Http\Controllers;


use App\Models\Student;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function registerStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'admission_number' => 'required|string|max:200',
            'class' => 'required|string|max:10',
            'section' => 'required|string|max:10',
            'roll_number' => 'required|string|max:10',
            'date_of_birth' => ['required', 'regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
            'gender' => ['required', 'regex:/^(FEMALE|MALE)$/'],
            'blood_group' => ['required', 'regex:/^(A|B|AB|O)[+-]$/'],
            'admission_details' => 'required|string|max:200',
            'transport_details' => 'required|string|max:200',
            'nationality' => 'required|string|max:100',
            'religion' => 'required|string|max:100',
            'mother_tongue' => 'required|string|max:100',
            'aadhar_number' => ['required', 'regex:/^\d{4}\s\d{4}\s\d{4}$/'],
            'address' => 'required|string|max:400',
            'emergency_contact_number' => ['required', 'regex:/((\+*)((0[ -]*)*|((91 )*))((\d{12})+|(\d{10})+))|\d{5}([- ]*)\d{6}$/']


        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }


        $student = Student::create($request->toArray());
        $response = ['message' => 'Student Successfully Registered'];
        return response($response, 200);
    }

    public function updateStudentDetails(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'prohibited',
            'admission_number' => 'required|string|max:200',
            'class' => 'prohibited',
            'section' => 'prohibited',
            'roll_number' => 'prohibited',
            'date_of_birth' => ['regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
            'gender' => 'prohibited',
            'blood_group' => 'prohibited',
            'admission_details' => 'prohibited',
            'transport_details' => 'prohibited',
            'nationality' => 'string|max:100',
            'religion' => 'string|max:100',
            'mother_tongue' => 'string|max:100',
            'aadhar_number' => ['regex:/^\d{4}\s\d{4}\s\d{4}$/'],
            'address' => 'string|max:400',
            'emergency_contact_number' => ['regex:/((\+*)((0[ -]*)*|((91 )*))((\d{12})+|(\d{10})+))|\d{5}([- ]*)\d{6}$/']


        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $student = Student::where('admission_number', $request->admission_number)->first();
        if ($student == null) {
            error_log($request);
            return View('Student Not Found', [], 404);
        }

        if ($student->updateOrFail($request->all()) === false) {
            return response(
                "Couldn't update the user with id {$request->id}",
                Response::HTTP_BAD_REQUEST
            );
        }
        $response = ['message' => 'Student Successfully Updated'];
        return response($response, 200);
    }

    public function getStudentDetailsByAdmissionNumber(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'admission_number' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $student = Student::where('admission_number', $request->admission_number)->first();
        if ($student == null) {
            error_log($request);
            return View('Student Not Found', [], 404);
        }


        $parent_list_for_student = [];
        $parent_list_for_student = User::select("users.name","users.email","users.mobile_number","users.user_type")->join("students", "students.admission_number", "=", "users.admission_number")->where("students.admission_number", "=", $request->admission_number)->get();
        foreach ($parent_list_for_student as $value) {
            if ($value->user_type === "MOTHER") {
                $student->mother_details = $value;
            } else if ($value->user_type === "FATHER") {
                $student->father_details = $value;
            }
        }
        if ($parent_list_for_student != null) {
            error_log($parent_list_for_student);
        }

        $response = $student;
        return response($response, 200);
    }

    public function getFeesDetails(Request $request)
    {
        $fees_details = DB::table('fee_details')
            ->join('users', 'users.admission_number', '=', 'fee_details.admission_number') // joining the contacts table , where user_id and contact_user_id are same
            ->select('fee_details.*', 'users.*')
            ->where('fee_details.admission_number', '=', $request->admission_number)
            ->get();
        $fees_details = $fees_details->unique('admission_number');
        if (sizeof($fees_details) > 0) {
            $response = ['FeeDetails' => $fees_details];
            return response($response, 200);
        } else {

            $response = ["message" => "Fees Details is Empty "];
            return response($response, 422);
        }
    }
}
