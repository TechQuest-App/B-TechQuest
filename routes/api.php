<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CertificateFullNameController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\ResourcesController;
use App\Http\Controllers\Api\RoadmapController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WeekController;
use App\Http\Controllers\Api\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

## ---------------------AUTH Module------------------##
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});
## ---------------------Users Module------------------##
Route::get('/users', UserController::class);

## ---------------------Category Module------------------##
Route::get('/categories', CategoryController::class);

## ---------------------Courses Module ------------------##
Route::prefix('/courses')->controller(CourseController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/category/{category}', 'category');
    Route::get('/search', 'search');
    Route::get('/{course}', 'show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'store');
        Route::post('/update/{course}', 'update');
        Route::post('/delete/{course}', 'destroy');
    });
});

## ---------------------Carts Module ------------------##
Route::middleware('auth:sanctum')->controller(CartController::class)->group(function () {
    Route::get('/cart','index');
    Route::post('/cart', 'store');
});

## ---------------------WishList Module ------------------##
Route::middleware('auth:sanctum')->controller(WishListController::class)->group(function () {
    Route::get('/wishlist','index');
    Route::post('/wishlist', 'store');
});

## ---------------------Certificate Module ------------------##
Route::controller(CertificateController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/certificate','index'); // for mentor
    Route::post('/certificate', 'store');
    Route::post('/fullName', 'fullName'); // for the form
    Route::get('/courseCertificate/{course_id}', 'oneCertificate'); // for student
    Route::get('/certificates', 'allCertificates');
});
//Route::get('/certificate/fullName', [CertificateFullNameController::class,'fullName']);
//Route::middleware('auth:sanctum')->controller(certificateController::class)->group(function () {
//    Route::get('/certificate','index');
//    Route::post('/wishlist', 'store');
//});

## ---------------------Section Module ------------------##
Route::controller(SectionController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/section', 'store');
    Route::post('/section/update/{section}', 'update');
    Route::post('/section/delete/{section}', 'destroy');
});

## ---------------------Lesson Module ------------------##
Route::controller(LessonController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/lesson', 'store');
    Route::post('/lesson/update/{lesson}', 'update');
    Route::post('/lesson/delete/{lesson}', 'destroy');
});

## ---------------------RoadMaps Module ------------------##
Route::controller(RoadmapController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/roadmap', 'store');
    Route::post('/roadmap/update/{roadmap}', 'update');
    Route::post('/roadmap/delete/{roadmap}', 'destroy');
    Route::get('/roadmap/{id}','index');
});

Route::controller(LevelController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/level', 'store');
    Route::post('/level/delete/{level}', 'destroy');
    Route::get('/level/{id}','index');
});

Route::controller(WeekController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/week', 'store');
    Route::post('/week/delete/{week}', 'destroy');
    Route::get('/week/{id}','index');
});

Route::controller(TopicController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/topic', 'store');
    Route::post('/topic/update/{topic}', 'update');
    Route::post('/topic/delete/{topic}', 'destroy');
    Route::get('/topic/{Week_id}','index');
});

Route::controller(ResourcesController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/resources', 'store');
    Route::post('/resources/update/{resource}', 'update');
    Route::post('/resources/delete/{resource}', 'destroy');
    Route::get('/resources/{wee_id}','index');
});
