<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Survey\SurveyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('registration', [AuthController::class, 'registration'])->name('register');

Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 


Route::middleware(['auth'])->group(function () {
  
        Route::get('dashboard', [SurveyController::class, 'dashboard'])->name('dashboard'); 
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('survey', [SurveyController::class, 'survey'])->name('survey');
        Route::post('post-survey', [SurveyController::class, 'surveypost'])->name('survey.post');

        Route::get('subdash', [SurveyController::class, 'subDash'])->name('subdash');

});