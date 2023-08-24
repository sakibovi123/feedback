<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("/register", [\App\Http\Controllers\auth\AuthController::class, "register"])->name("register");
Route::post('/login', [\App\Http\Controllers\auth\AuthController::class, "login"])->name("login");

Route::group(["middleware" => "api"], function ($routes){
    Route::post('/logout', [\App\Http\Controllers\auth\AuthController::class, "logout"]);
    Route::post('/refresh', [\App\Http\Controllers\auth\AuthController::class, "refresh"]);
    Route::post('/me', [\App\Http\Controllers\auth\AuthController::class, "me"]);

    // form url
    Route::get("/forms", [Controllers\FormController::class, "index"])->name("get_forms");
    Route::get("/form-details/{slug}/", [Controllers\FormController::class, "show"])->name("form-details");
    Route::post("/create-form", [Controllers\FormController::class, "store"])->name("save_form");
    Route::post("/save-response/{slug}/", [Controllers\FormController::class, "post_feedback"])->name("post_feedback");

    Route::get("/responses/{slug}/", [Controllers\FormController::class, "show_form_wise_feedback"]);
});

