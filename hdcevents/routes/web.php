<?php

use Illuminate\Support\Facades\Route;

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

/* Para se criar u  novo controler add mais um terminal "entra na pasta, nesse exemplo o cd. \hdcevents\"
    "Enter"
    e depois: php artisan make:controller "nome do controller" nesse ex: EventController OBS:O nome do controller sempre é no singular
*/

/* dando o "include" no meu controller EventController.php, que está dentro da pasta controllers */ /* */
use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index']);/*Index mostra todos os registros */
/*Metodo para criar um evento no projeto la dentro do EventController*/ 
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');/* create mostra o formulario de criar registro no banco*/
Route::get('/events/{id}', [EventController::class, 'show']);/* show é para mostrar um dado especifico*/
Route::post('/events', [EventController::class, 'store']);/*store é para enviar um dados pro banco */
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');/**Criando uma rota para deletar um evento */
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');/*Criando a rota para o Edit */
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');/*Criando a rota para o Edit */

Route::get('/contact', function(){
    return view('contact');
});

Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');

Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');