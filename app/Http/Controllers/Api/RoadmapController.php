<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoadmapResource;
use App\Models\RoadMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoadmapController extends Controller
{
    public function index($id)
    {
        $roadmaps = Roadmap::where('id', $id)->first();
        return new RoadmapResource($roadmaps);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ],[],[
            'title' => 'Title',
            'description' => 'Description',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }

        $roadmap = RoadMap::create(request()->all());
        if ($roadmap) {
            return ApiResponse::sendResponse(201, 'Created Successfully');
        }
        return ApiResponse::sendResponse(500, 'Something went wrong');
    }

    public function update(Request $request, $id)
    {
        $roadmap = RoadMap::where('id', $id)->first();
        if (!$roadmap) {
            return ApiResponse::sendResponse(200, 'Roadmap not found');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ],[],[
            'title' => 'Title',
            'description' => 'Description',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }
        $update = $roadmap->update(request()->all());
        if ($update) {
            return ApiResponse::sendResponse(200, 'Updated Successfully');
        }
        return ApiResponse::sendResponse(500, 'Something went wrong');
    }

    public function destroy($roadmap_id)
    {
        $roadmap = RoadMap::findOrFail($roadmap_id);
        $deleted = $roadmap->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Roadmap deleted successfully.');
        }
    }
}
