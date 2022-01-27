<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\StudentController;
use App\Models\Student;

Route::post('login', [StudentController::class, 'signin']);
Route::post('classuser', [StudentController::class, 'getUserOrClass']);

Route::post('getmemebership', [StudentController::class, 'membershipsforclass']);

Route::get('subjects', [StudentController::class, 'getsubjects']);
Route::get('genres', [StudentController::class, 'getgenres']);
Route::get('themes', [StudentController::class, 'getthemes']);
Route::post('levels', [StudentController::class, 'getlevels']);
Route::post('agegroup', [StudentController::class, 'getagegroup']);

Route::post('getleveledressources', [StudentController::class, 'getleveledressources']);
Route::post('getageressources', [StudentController::class, 'getageressources']);
Route::post('getthemesressources', [StudentController::class, 'getthemesressources']);
Route::post('getgenresressources', [StudentController::class, 'getgenresressources']);
Route::post('getsubjectsressources', [StudentController::class, 'getsubjectsressources']);


Route::post('getressource', [StudentController::class, 'getressource']);


Route::post('addscore', [StudentController::class, 'addscore']);
Route::post('getscore', [StudentController::class, 'getscore']);


Route::post('addaward', [StudentController::class, 'addaward']);
Route::post('getawards', [StudentController::class, 'getawards']);
Route::get('getallawards', [StudentController::class, 'getawardsall']);

Route::post('getmembership', [StudentController::class, 'getmemebershipforclass']);
Route::post('getmembership', [StudentController::class, 'getmemebershipforparent']);


Route::post('getreading', [StudentController::class, 'getreading']);
Route::post('addreading', [StudentController::class, 'addreading']);

Route::post('countressources', [StudentController::class, 'countressources']);

Route::post('countreading', [StudentController::class, 'countreading']);



