<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\FamilyGroup;
use Carbon\Carbon;

class PassportAuthController extends Controller
{
    /**
     * handle user registration request
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'admission_number' => 'required',
            'mobile_number' => 'required|max:10'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        /* 
            Next validation needs to be done to see if admission number
            is present in student master and email and mobile number match
            with whats present in parents_table
        */

        $user = User::where('email', $request->email)->first();


        if ($user) {
            $response = ["message" => "User With Email Already Registered"];
            return response($response, 200);
        } else {
            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = User::create($request->toArray());
            $token = $user->createToken('API Token')->accessToken;
            $response = ['token' => $token];
            return response($response, 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {

            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $tokenResult = $user->createToken('API Token');
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addDays(2);
                $token->save();
                $response = ['token' => $token];
                $response = [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                    'role_type' => $user->role_type
                ];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }

        /* 
            Implement logic to lock out the account in case of 5 password tries
        */
    }


    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function getUserDetailsByemailId(Request $request)
    {
    }
}
