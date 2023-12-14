<?php

use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CountriesController;
use App\Http\Controllers\API\AuthController;

// Route::controller(CountriesController::class)->group(function(){
//     Route::get('/api/countries/list', 'list');
// })->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/api/countries/list', [CountriesController::class, 'list']);
});




//Route::get('/api/auth', [AuthController::class, 'auth']);

//Route::get('/callback', [AuthController::class, 'callback']);


Route::get('/private', function () {
  return response()->json([
    'message' => 'Your token is valid; you are authorized.',
  ]);
})->middleware('auth');

Route::get('/scope', function () {
    return response()->json([
      'message' => 'Your token is valid and has the `read:messages` permission; you are authorized.',
    ]);
})->middleware('auth')->can('read:messages');

Route::get('/', function () {
  if (! auth()->check()) {
    return response()->json([
      'message' => 'You did not provide a valid token.',
    ]);
  }

  return response()->json([
    'message' => 'Your token is valid; you are authorized.',
    'id' => auth()->id(),
    'token' => auth()?->user()?->getAttributes(),
  ]);
});

Route::get('/me', function () {
  $user = auth()->id();
  $profile = cache()->get($user);

  if (null === $profile) {
    $endpoint = Auth0::management()->users();
    $profile = $endpoint->get($user);
    $profile = Auth0::json($profile);

    cache()->put($user, $profile, 120);
  }

  $name = $profile['name'] ?? 'Unknown';
  $email = $profile['email'] ?? 'Unknown';

  return response()->json([
    'name' => $name,
    'email' => $email,
  ]);
})->middleware('auth');
