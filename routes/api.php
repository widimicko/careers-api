<?php

use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LandingController;
use App\Http\Controllers\API\LowonganController;
use App\Http\Controllers\API\RecruitmentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\DashboardController;
// use App\Http\Controllers\API\RecruitmentController as APIRecruitmentController;
use App\Models\Lowongan;
use App\Models\Peserta;
use App\Models\Recruitment;
use App\Models\Participant;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('lowongan/peserta', [LandingController::class, 'lowongan']);
// Route::get('lowongan/peserta/{id}', [LandingController::class, 'show']);
// Route::post('lowongan/peserta/{id}', [LandingController::class, 'daftar']);


Route::get('search/{data}', [HomeController::class, 'search']);
// Route::get('search', [HomeController::class, 'search']);
Route::get('careers', [HomeController::class, 'lowongan']);
Route::get('careers-detail/{id}', [HomeController::class, 'show']);
Route::post('careers-daftar/{id}', [HomeController::class, 'daftar']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/add', [UserController::class, 'store']);
// Route::post('lowongan', [LowonganController::class, 'store']);
// Auth::routes();
Route::group(['middleware' => 'auth:api'], function(){
	Route::post('details', [UserController::class, 'details']);
    Route::get('lowongan', [RecruitmentController::class, 'index']);
    Route::post('lowongan-create', [RecruitmentController::class, 'store']);
    Route::post('lowongan-update/{id}', [RecruitmentController::class, 'update']);
    Route::get('lowongan-detail/{id}', [RecruitmentController::class, 'show']);
    Route::delete('lowongan-delete/{id}', [RecruitmentController::class, 'destroy']);

    Route::get('dashboard/internship', [DashboardController::class, 'index']);
    Route::get('dashboard/recruitment', [DashboardController::class, 'recruitment']);

    Route::get('participant/internship', [ParticipantController::class, 'index']);
    Route::get('participant/recruitment', [ParticipantController::class, 'recruitment']);
    Route::get('participant/{id}', [ParticipantController::class, 'show']);

    // Route::resource('careers', RecruitmentController::class);
});
