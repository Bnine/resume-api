<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix("/v1")->middleware('check.bearer')->group(function(){
    Route::get('profile/{m_id?}', 'MainController@index')->name('main.profile');
    Route::get('work-experience/{m_id?}', 'MainController@workExpcn')->name('main.workExperience');
    Route::post('email', 'MainController@sendRequestMail')->name('main.sendingEmail');
});

