<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function index($week_id)
    {
        $topics= Topic::where('week_id', $week_id)->get();
        return TopicResource::collection($topics);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'week_id' => 'required|exists:weeks,id',
        ],[],[
            'week_id' => 'Week Id',
            'topic' => 'Topic',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $topic = Topic::create(request()->all());
        if ($topic) {
            return ApiResponse::sendResponse(200,'Topic created successfully.',new TopicResource($topic));
        }
        return ApiResponse::sendResponse(500,'Something went wrong.');
    }

    public function update(Request $request, Topic $topic)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'week_id' => 'required|exists:weeks,id',
        ],[],[
            'week_id' => 'Week Id',
            'topic' => 'Topic',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $topic->update(request()->all());
        if ($topic) {
            return ApiResponse::sendResponse(200,'Topic updated successfully.',new TopicResource($topic));
        }
        return ApiResponse::sendResponse(500,'Something went wrong.');
    }

    public function destroy($id)
    {

        $topic = Topic::findOrFail($id);
        $deleted = $topic->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Topic Deleted Successfully.');
        }
    }
}
