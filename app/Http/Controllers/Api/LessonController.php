<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Section;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function store(Request $request){
        $section = Section::findOrFail(request('section_id'));
        if (!$section) {
            return ApiResponse::sendResponse(200,'Section not found');
        }
        if ($request->user()->id != $section->course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:lessons',
            'video' => 'required|mimetypes:video/mp4' //need help here !!
        ],[],[
            'name' => 'Name',
            'video' => 'Video',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }
        $file = request()->file('video');
        $getId = new getID3();
        $fileInfo= $getId->analyze($file->getPathname());
        $duration = 0;
        if (isset($fileInfo['playtime_seconds'])) {
            $duration = round($fileInfo['playtime_seconds'],2);
        }
        $fileName= time() . '.' . $file->getClientOriginalName();
        $path = $file->move(public_path('lessons'), $fileName);
        $lesson = Lesson::create([
            'title' => request('title'),
            'url' => $fileName,
            'duration' => $duration,
            'section_id' => $section->id,
        ]);
        if ($lesson) {
            return ApiResponse::sendResponse(201,'Lesson created successfully');
        }
        return ApiResponse::sendResponse(500,'Lesson not created');
    }

    public function update(Request $request, $lessonId)
    {
        $lesson = Lesson::where('id', $lessonId)->first();
        if (!$lesson) {
            return ApiResponse::sendResponse(200,'Lesson not found');
        }
        if ($request->user()->id != $lesson->section->course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'video' => 'mimetypes:video/mp4'
        ],[],[
            'name' => 'Name',
            'video' => 'Video',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.', $validator->errors());
        }

        if ($request->video != null) {
            unlink(public_path('lessons/' . $lesson->url));
            $file = request()->file('video');
            $getId = new getID3();
            $fileInfo= $getId->analyze($file->getPathname());
            $duration = $lesson->duration;
            if (isset($fileInfo['playtime_seconds'])) {
                $duration = round($fileInfo['playtime_seconds'],2);
            }
            $fileName= time() . '.' . $file->getClientOriginalName();
            $path = $file->move(public_path('lessons'), $fileName);
        }

        $update = $lesson->update([
            'title' => request('title'),
            'url' => $fileName ?? $lesson->url,
            'duration' => $request->video ? $duration : $lesson->duration,
        ]);
        if ($update) {
            return ApiResponse::sendResponse(201,'Lesson updated successfully',new LessonResource($lesson));
        }
        return ApiResponse::sendResponse(500,'Lesson not updated');
    }

    public function destroy(Request $request,$lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        if ($request->user()->id != $lesson->section->course->mentor_id) {
            return ApiResponse::sendResponse(403,'You are not authorized to edit this course');
        }
        $deleted = $lesson->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Lesson deleted successfully');
        }
        return ApiResponse::sendResponse(500,'Lesson not deleted');
    }
}
