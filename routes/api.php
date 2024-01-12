<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

Route::get('/productoras', [App\Http\Controllers\Api\ProduController::class, 'index']);
Route::get('/productoras/{producers}/conductores', [App\Http\Controllers\Api\ProduController::class, 'drivers']);
Route::get('/horario/horas', [App\Http\Controllers\Api\HorarioController::class, 'hours']);

Route::middleware('auth:api')->group(function(){
    Route::get('/appointments', [App\Http\Controllers\Api\AppointmentController::class, 'index']);
    Route::post('/appointments', [App\Http\Controllers\Api\AppointmentController::class, 'store']);
    Route::get('/appointmentsDrivers', [App\Http\Controllers\Api\AppointmentDriverController::class, 'index']);
    Route::post('/fcm/token', [App\Http\Controllers\Api\FirebaseController::class, 'postToken']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
}); 
    
