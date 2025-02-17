<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get(
    "tokens/{resourceName}/{id}",
    "\Karelvanzijl\SanctumTokens\Http\SanctumController@tokens"
);
Route::post(
    "tokens/{resourceName}/{id}",
    "\Karelvanzijl\SanctumTokens\Http\SanctumController@createToken"
);
Route::post(
    "tokens/{resourceName}/{id}/revoke",
    "\Karelvanzijl\SanctumTokens\Http\SanctumController@revoke"
);
