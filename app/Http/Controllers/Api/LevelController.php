<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index($id)
    {
        $level = Level::where('id', $id)->first();
        if (!$level){
            return ApiResponse::sendResponse(200,'Level Not Found');
        }
        return ApiResponse::sendResponse(200,'Level Retrieved Successfully',new LevelResource($level));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'roadmap_id' => 'required|exists:roadmaps,id',
        ],[],[
            'name'=>'Level Name',
            'roadmap_id'=>'Roadmap Id',
        ]);
        if($validator->fails()){
            return ApiResponse::sendResponse(422,'Validation Error.',$validator->errors());
        }
        $created = Level::create($request->all());
        if ($created){
            return ApiResponse::sendResponse(200,'Level Created Successfully');
        }
        return ApiResponse::sendResponse(500,'Level Created Failed');
    }

    public function destroy( $level_id)
    {
        $level = Level::findOrFail($level_id);
        $deleted = $level->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Level deleted successfully.');
        }
    }
}
