<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * register a user 
     *
     * @return void
     */
    public function register()
    {
        $data = $this->validateData([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);
        if (!isset($data['errors'])) {
            $validatedData = request()->all();
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = User::create($validatedData);
            $data['success'] =  true;
            $data['user_id'] =  $user->id;
            $data['token'] =  $user->createToken('')->accessToken;
            $user->sendRegisterNotification();
        } else {
            $data['success'] =  false;
        }
        return response()->json(['data' => $data]);
    }


    /**
     * login a user
     *
     * @return void
     */
    public function login()
    {
        $data = $this->validateData([
            'username' => 'required',
            'password' => 'required',
        ]);

        //if email is sent, attempt with email, else with username
        if (!filter_var(request('username'), FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['username' => request('username'), 'password' => request('password')]);
        } else {
            Auth::attempt(['email' => request('username'), 'password' => request('password')]);
        }

        if (!isset($data['errors']) && Auth::user()) {
            if (!Auth::user()->hasVerifiedEmail()) {
                $data['success'] =  false;
                $data['message'] =  'Please verify your email';
            } else {
                $user = Auth::user();
                $data['success'] =  true;
                $data['user_id'] =  $user->id;
                $data['token'] =  $user->createToken('')->accessToken;
                $user->sendLoginNotification();
            }
        } else {
            $data['success'] =  false;
        }
        return response()->json(['data' => $data]);
    }

    /**
     * validate data and return data with errors if exist
     *
     * @param  array $rules
     * @return void
     */
    public function validateData(array $rules)
    {
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            $data['errors'] =  $validator->errors();
            return $data;
        }
    }
}
