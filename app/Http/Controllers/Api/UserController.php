<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __invoke(Request $request)
    {
//        dd('you are here');
        // to find one record
//        $users = User::findOrFail(30);
//        return new UserResource($users) ;
        // to get all
        $users = User::get();
        return UserResource::collection($users);
    }
//    public function show(Request $request)
//    {
//        $user = JWTAuth::parseToken()->authenticate();
//        return response()->json($user);
//    }
public function index(Request $request)
{
    dd('i\'m here');
}
}
