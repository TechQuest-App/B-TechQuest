<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke(Request $request)
    {
        // to get all
        $categories = Category::get();
        if ($categories->count() > 0)
            return ApiResponse::sendResponse(200,'category retrieved successfully', CategoryResource::collection($categories));
        return ApiResponse::sendResponse(200,'category not found',[]);

    }
}
