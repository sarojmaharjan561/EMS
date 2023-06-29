<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Models\Company;

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

Route::get('/employees',[EmployeeController::class,'index']);
Route::post('/employees',[EmployeeController::class,'store']);
Route::patch('/employees/{employee}',[EmployeeController::class,'update']);
Route::delete('/employees/{employee}',[EmployeeController::class,'destroy']);

Route::get('/company',[CompanyController::class,'index']);
Route::post('/company',[CompanyController::class,'store']);
Route::patch('/company/{company}',[CompanyController::class,'update']);
Route::delete('/company/{company}',[CompanyController::class,'destroy']);
