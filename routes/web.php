<?php

use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\ExcelUserController;
use App\Http\Controllers\ExcelUserControllerV2;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('dasboard');
});






Route::post('/upload/excel', [ExcelUploadController::class,"upload"])->name('upload.excel');

Route::post('/upload/user/excel', [ExcelUserControllerV2::class,"upload"])->name('upload.user.excel');


Route::get('/download/user/excel' , [ExcelUserControllerV2::class , "export"])->name('download.user.excel'); 


Route::get('/list',  [ExcelUserControllerV2::class , "list"])->name('list');