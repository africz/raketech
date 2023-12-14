<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\CountriesController;
  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
  

Route::controller(CountriesController::class)->group(function(){
    Route::get('/api/countries/list', 'list');
});
