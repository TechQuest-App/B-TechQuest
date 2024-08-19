<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
//        $credentials = $request->only('email', 'password');
//
//        if ($token = $this->guard()->attempt($credentials)) {
//            return $this->respondWithToken($token);
//        }
//
//        return response()->json(['error' => 'Unauthorized'], 401);
        $validator = Validator::make(request()->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ], [],[
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422,'LOGIN VALIDATION ERROR', $validator->errors());
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $data['token'] = $user->createToken('TechQuest')->plainTextToken;
            $data['name'] = $user->f_name;
            $data['email'] = $user->email;
            return ApiResponse::sendResponse(201,'User Logged In Successfully', $data);
        }else {

            return ApiResponse::sendResponse(401,'User Credentials dosen\'t exist', []);
        }

    }

    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ], [],[
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422,'REGISTER VALIDATION ERROR', $validator->errors());
        }
        $user = User::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => request('phone'),
            'pic' => 'https://via.placeholder.com/640x480.png/00ee88?text=ea',
            'is_active' => 1
        ]);

        $data['token'] = $user->createToken('TechQuest')->plainTextToken;
        $data['f_name'] = $user->f_name;
        $data['l_name'] = $user->l_name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201,'REGISTER SUCCESSFUL', $data);
    }

    public function logout(Request $request)
    {
       $request->user()->currentAccessToken()->delete();
       return ApiResponse::sendResponse(200, 'Logged Out Successfully',[]);

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
