<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeekResource;
use App\Models\Level;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeekController extends Controller
{
    public function index($id )
    {
//        $weeks = Week::where('level_id', $id)->paginate(2);
        $weeks = Week::where('level_id', $id)->get();
//        if (count($weeks) > 0) {
//            if ($weeks->total() > $weeks->perPage()) {
//                $data = [
//                    'records' => WeekResource::collection($weeks),
//                    'pagination' => [
//                        'total' => $weeks->total(),
//                        'per_page' => $weeks->perPage(),
//                        'current_page' => $weeks->currentPage(),
//                        'links' => [
//                            'first' => $weeks->url(1),
//                            'last' => $weeks->url($weeks->lastPage()),
//                            'prev' => $weeks->url($weeks->previousPageUrl()),
//                            'next' => $weeks->url($weeks->nextPageUrl()),
//                        ]
//                    ]
//                ];
//            } else {
//                $data = new WeekResource($weeks);
//            }
//            return ApiResponse::sendResponse(200,'Weeks retrieved successfully.',$data);
//        }

        if (!$weeks) {
            return ApiResponse::sendResponse(200, 'Weeks Not Found' ,[]);
        }
//        dd($weeks);
        return ApiResponse::sendResponse(200, 'Weeks Found' ,WeekResource::collection($weeks));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'level_id' => 'required|exists:levels,id',
            'number' => 'required|integer|min:1',
        ],[],[
            'level_id' => 'Level',
            'number' => 'Number',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }
        $week = Week::create(request()->all());
        if ($week) {
            return ApiResponse::sendResponse(200,'Week created successfully.',[]);
        }
        return ApiResponse::sendResponse(500,'Something went wrong.',[]);
    }

    public function destroy(Request $request, $week_id)
    {
        $week = Week::findOrFail($week_id);
        $deleted = $week->delete();
        if ($deleted) {
            return ApiResponse::sendResponse(200,'Week Deleted Successfully.');
        }
    }
}
