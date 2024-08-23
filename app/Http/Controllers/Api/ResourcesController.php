<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResourcesResource;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResourcesController extends Controller
{

    public function index($week_id)
    {
        $resources= Resource::where('week_id', $week_id)->get();
        return ResourcesResource::collection($resources);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'course_id' => ['required', 'exists:courses,id', Rule::unique('resources')->where(function ($query) use ($request) {
                return $query->where('course_id', $request->input('course_id'))
                    ->where('week_id', $request->input('week_id'));
            })],
            'week_id' => ['required', 'exists:weeks,id', Rule::unique('resources')->where(function ($query) use ($request) {
                return $query->where('course_id', $request->input('course_id'))
                    ->where('week_id', $request->input('week_id'));
            })],
        ],[],[
            'week_id' => 'Week Id',
            'course_id' => 'Course Id',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $resource = Resource::create(request()->all());
        if ($resource) {
            return ApiResponse::sendResponse(200,'Resource Created Successfully.',new ResourcesResource($resource));
        }
        return ApiResponse::sendResponse(500,'Something Went Wrong.');

    }

    public function update(Request $request, Resource $resource)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|unique|exists:courses,id',
            'week_id' => 'required|unique|exists:weeks,id',

        ],[],[
            'course_id' => 'Course Id',
            'week_id' => 'Week Id',
        ]);

        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $resource->update(request()->all());
        if ($resource) {
            return ApiResponse::sendResponse(200,'Resource Updated Successfully.',new ResourcesResource($resource));
        }
        return ApiResponse::sendResponse(500,'Something went wrong.');
    }

    public function destroy($id)
    {

        $resource = Resource::findOrFail($id);
        $deleted = $resource->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Resource Deleted Successfully.');
        }
    }
}
