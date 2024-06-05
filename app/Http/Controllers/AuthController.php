<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function testing() {
        return response()->json(['status' => true, 'message' => 'User registered successfully'], 200);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'confirmpassword' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'please check form again'], 400);
        }

        $name = !empty($request->input('name')) ? $request->input('name') : 'XXX';
        $email = !empty($request->input('email')) ? $request->input('email') : 'XXX';
        $phone = !empty($request->input('phone')) ? $request->input('phone') : 'XXX';
        $password = !empty($request->input('password')) ? $request->input('password') : 'XXX';

        try {
            $users = new User();

            $users->name = $name;
            $users->email = $email;
            $users->phonenumber = $phone;
            $users->password = bcrypt($password);

            $users->save();
         }
         catch(\Exception $e){
            return response()->json(['status' => false, 'message' => 'register failed,  email already taken', 'server_message' => $e->getMessage()], 500);
         }

        return response()->json(['status' => true, 'message' => 'register success'], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'please check your password or email', 'server_message' => 'validation failed'], 400);
        }

        $emailOrPhone = !empty($request->input('email_or_phone')) ? $request->input('email_or_phone') : 'XXX';
        $password = !empty($request->input('password')) ? $request->input('password') : 'XXX';

        try {
            $user = User::where(function($query) use ($emailOrPhone) {
                        $query->where('email', $emailOrPhone)
                            ->orWhere('phonenumber', $emailOrPhone);
                    })
                    ->where('role', 'user')
                    ->first();
            if ($user && Hash::check($password, $user->password)) {
                $data = [
                    'user_id' => $user->id,
                    'role' => $user->role,
                ];
                return response()->json(['status' => true, 'message' => 'Login successfully', 'data' => $data], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'please check email or password'], 500);
            }
        }
        catch(\Exception $e){
            return response()->json(['status' => false, 'message' => 'please check password or email', 'server_message' => 'system error'], 500);
        }
    }
}
