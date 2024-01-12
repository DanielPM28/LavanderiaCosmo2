<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth','admin'])->group(function () {
    //RUTAS PRODUCTORAS
 Route::get('/productoras', [App\Http\Controllers\admin\ProducersController::class, 'index']);

 Route::get('/productoras/create', [App\Http\Controllers\admin\ProducersController::class, 'create']);
 Route::get('/productoras/{producers}/edit', [App\Http\Controllers\admin\ProducersController::class, 'edit']);
 Route::post('/productoras', [App\Http\Controllers\admin\ProducersController::class, 'sendData']);

 Route::put('/productoras/{producers}', [App\Http\Controllers\admin\ProducersController::class, 'update']);
 Route::delete('/productoras/{producers}', [App\Http\Controllers\admin\ProducersController::class, 'destroy']);
 //Rutas Conductores

Route::resource('conductores', 'App\Http\Controllers\admin\ConductoresController');
//Rutas producciones
 Route::resource('producciones', 'App\Http\Controllers\admin\ProduccionesController');
//Rutas Reportes
Route::get('/reportes/citas/line', [App\Http\Controllers\admin\ChartController::class, 'appointments']);
Route::get('/reportes/conductores/column', [App\Http\Controllers\admin\ChartController::class, 'drivers']);
Route::get('/reportes/conductores/column/data', [App\Http\Controllers\admin\ChartController::class, 'driversJson']);

Route::post('/fcm/send', [App\Http\Controllers\admin\FirebaseController::class, 'sendAll']);

});
Route::middleware(['auth','conductor'])->group(function () {
    Route::get('/horario', [App\Http\Controllers\conductor\HorarioController::class, 'edit']);
    Route::post('/horario', [App\Http\Controllers\conductor\HorarioController::class, 'store']);
});

Route::middleware('auth')->group(function(){

    Route::get('/reservarcitas/create', [App\Http\Controllers\AppointmentController::class, 'create']);
    Route::post('/reservarCitas', [App\Http\Controllers\AppointmentController::class, 'store']);
    Route::get('/miscitas', [App\Http\Controllers\AppointmentController::class, 'index']);
    Route::get('/miscitas/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show']);
    Route::post('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel']);
    Route::post('/miscitas/{appointment}/confirm', [App\Http\Controllers\AppointmentController::class, 'confirm']);
    Route::get('/miscitas/{appointment}/cancel', [App\Http\Controllers\AppointmentController::class, 'formCancel']);
    
    //JSON
    //JSON
   


    Route::get('/profile', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/profile', [App\Http\Controllers\UserController::class, 'update']);
});

