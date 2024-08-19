<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\WishListResource;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WishListController extends Controller
{
    public function index(Request $request)
    {
        $wishList = WishList::firstOrCreate(['user_id' => $request->user()->id]);
        return new WishListResource($wishList);
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
        $wishList = WishList::firstOrCreate(['user_id' => $request->user()->id]);

        if ($wishList->course()->where('course_id', $request->course_id)->exists()) {
            return ApiResponse::sendResponse(200, 'Course already in cart', []);
        }

        $wishList->course()->attach($request->course_id);
        return ApiResponse::sendResponse(201, 'Added To Cart Successfully',[]);

    }
}
