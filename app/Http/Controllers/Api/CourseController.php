<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResourece;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::get();
        if($courses){

            return ApiResponse::sendResponse(200, 'Courses retrieved successfully.', CourseResourece::collection($courses));
        }
        return ApiResponse::sendResponse(200, 'Courses not found.',[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['mentor_id'] = $request->user()->id;
        $record = Course::create($data); // see create record
        if ($record)
            return ApiResponse::sendResponse(201,'Course created successfully.',new CourseResourece($record));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::where('id' , $id)->first();
        if ($course){
            return ApiResponse::sendResponse(200, 'course retrieved successfully', new CourseResourece($course));
        }
        return ApiResponse::sendResponse(200, 'course not found', []);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, $CourseId)
    {
        $course = Course::findOrFail($CourseId);
        if ($course->mentor_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, 'you aren\'t authorized to perform this action.', []);
        }
        $data = $request->validated();
        $updated = $course->update($data);
        if ($updated)
            return ApiResponse::sendResponse(201,'Course updated successfully.',new CourseResourece($course));
    }

    public function category($category_id)
    {
        $courses = Course::where('category_id' , $category_id)->get;
        if ($courses) {
            return ApiResponse::sendResponse(200, 'Courses retrieved successfully.', CourseResourece::collection($courses));
        }
        return ApiResponse::sendResponse(200, 'course not found', []);
    }

    public function search(Request $request)
    {
         $word = $request->has('search') ? $request->input('search') : null;
         $courses = Course::when($word != null, function ($q) use ($word) {
             $q->where('name', 'like', '%' . $word . '%');
         })->latest()->get();
         if (count(collect($courses)) > 0) {
             return ApiResponse::sendResponse(200, 'Courses retrieved successfully.', CourseResourece::collection($courses));
         }
         return ApiResponse::sendResponse(200, 'No Matching Data', []);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$courseId)
    {
        $course = Course::findOrFail($courseId);
        if ($course->mentor_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, 'you aren\'t authorized to perform this action.', []);
        }
        $success = $course->delete();
        if ($success)
            return ApiResponse::sendResponse(200,'Course deleted successfully.', []);
    }
}
