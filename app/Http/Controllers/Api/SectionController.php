<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $course = Course::where('id', request('course_id'))->first();
        if (!$course) {
            return ApiResponse::sendResponse(200,'Course not found');
        }
        if ($request->user()->id != $course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sections',
        ],[],[
            'name' => 'Name',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $request['course_id'] = $course->id;
        $section = Section::create($request->all());
        if($section){
            return ApiResponse::sendResponse(201,'Section created successfully.');
        }
        return ApiResponse::sendResponse(500,'Something went wrong.',[]);
    }

    public function update(Request $request, $section_id)
    {
       $section = Section::where('id', $section_id)->first();
        if ($request->user()->id != $section->course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sections',
        ],[],[
            'name' => 'Name',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $update = $section->update($request->all());
        if ($update) {
            return ApiResponse::sendResponse(201,'Section updated successfully.');
        }
        return ApiResponse::sendResponse(500,'Something went wrong.',[]);

    }

    public function destroy(Request $request, $section_id)
    {
        $section = Section::findOrFail($section_id);
        if ($request->user()->id != $section->course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $deleted = $section->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Section deleted successfully.');
        }
    }
}
