<?php

use App\Http\Controllers\dataManipulator;
use App\Settings;

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

Route::get('/', function () {
    return view('welcome', ['srv_state'=>dataManipulator::objArrToAssoc(Settings::all())]);
});

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ru'])) {
        abort(400);
    }
    App::setLocale($locale);

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'MusicController@index')->name('home');
Route::get('/music/play/{music}/', 'MusicController@playlog')->name('mplay');
Route::get('/music/download/{music}/', 'MusicController@dwlog')->name('mdown');
Route::get('/music/rename/{music}/', 'MusicController@update')->name('mrename');
Route::get('/music/scan/', 'MusicController@filerefresh')->name('rescan');
Route::get('/users/', 'HomeController@usersControl')->name('ucontrol');
Route::get('/users/{user}', 'HomeController@userSwitch')->name('uswitch');
Route::get('/users_shutdown', 'HomeController@userShutdown')->name('ushutdown');
Route::get('/users_allow', 'HomeController@userGreenlight')->name('ugreen');
Route::get('/pwreset/{user}/{orig}', 'HomeController@pwResetAsk')->name('asknepw');
Route::post('/pwupdate/{user}', 'HomeController@usrUpdatePw')->name('nepwupd');
Route::post('/lockreg', 'HomeController@switchRegLock')->name('lockregon');
Route::get('/lockoff', 'HomeController@switchRegLock')->name('lockregoff');
Route::get('/useradd', 'HomeController@userAdd')->name('manualadd');
Route::post('/plususer', 'HomeController@addNewUser')->name('addnewuser');

