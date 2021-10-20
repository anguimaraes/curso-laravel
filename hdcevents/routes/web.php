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

Route::get('/', [EventController::class, 'index']);
/*Metodo para criar um evento no projeto la dentro do EventController*/ 
Route::get('/events/create', [EventController::class, 'create']);

Route::get('/contact', [EventController::class, 'contact']);
Route::get('/events/contact', [EventController::class, 'contact']);

Route::get('/products', [EventController::class, 'products']);
Route::get('/events/products', [EventController::class, 'products']);


