<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{

    public function index(Request $request)
    {

//        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id])->get();
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

//        return CartResource::collection($cart);
        return new CartResource($cart);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => ['required', 'exists:App\Models\Course,id'],
        ],[], [
            'course_id' => 'Course id',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }
//        $cart = Cart::where('user_id', $request->user()->id)->get();
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        if ($cart->course()->where('course_id', $request->course_id)->exists()) {
            return ApiResponse::sendResponse(200, 'Course already in cart', []);
        }

        $cart->course()->attach($request->course_id);
        return ApiResponse::sendResponse(201, 'Added To Cart Successfully',[]);
    }

    // TODO: checkout function

}
