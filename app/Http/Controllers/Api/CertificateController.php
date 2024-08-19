<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Models\Certificate_fullName;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $certificates = Certificate::where('course_id' ,$request->course_id)->first();
        if (!$certificates) {
            return ApiResponse::sendResponse(200,'Certificates not found',[] );
        }
        return new CertificateResource($certificates);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'description' => 'required',
        ],[],[
            'course_id' => 'Course Id',
            'description' => 'Description',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }
        $certificate = Certificate::create($request->all());
        if ($certificate) {
            return ApiResponse::sendResponse(200,'Certificate created successfully',[] );
        }
        return ApiResponse::sendResponse(500,'Something went wrong',[]);
    }

    public function fullName(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'full_name' => 'required',
            // adding userId from auth
        ],[],[
            'fullName' => 'Full Name',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
        }
        // we will make it show only once at first user
        $exist= Certificate_fullName::where('user_id', $request->user()->id)->exists();
        if ($exist) {
            // if this show do nothing
            return ApiResponse::sendResponse(200, 'Full Name already exists',[]);
        }
        $request['user_id'] =  $request->user()->id;
        $fullName = Certificate_fullName::create(request()->all());
        if ($fullName) {
            return ApiResponse::sendResponse(201,'Certificate Full Name Created Successfully',[] );
        }
        return ApiResponse::sendResponse(422,'Something went wrong',[]);
    }

    public function oneCertificate(Request $request, $course_id)
    {
        $cert = Certificate::where('course_id' ,$course_id)->first();
        if (!$cert) {
            return ApiResponse::sendResponse(200,'Certificate not found',[] );
        }
        return new CertificateResource($cert);
    }

}
