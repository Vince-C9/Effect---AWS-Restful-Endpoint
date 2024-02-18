<?php

use App\Http\Controllers\PDFContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Will come back and integrate sanctum if there's time.
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('pdf')->group(function(){
    Route::post('upload', [PDFContentController::class, 'store']);

    /*To come if time*/
    Route::get('/{id}');
});

