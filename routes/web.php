<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();


//ログアウト中のページ
Route::get('/login', 'Auth\LoginController@login');
Route::post('/login', 'Auth\LoginController@login');

Route::get('/register', 'Auth\RegisterController@register'); //新規登録入力なしはget
Route::post('/register', 'Auth\RegisterController@register'); //入力ありはpost

Route::get('/added', 'Auth\RegisterController@added');


//ログイン中のページ
Route::get('/top','PostsController@index');
Route::post('/post/create','PostsController@create');
Route::post('/update','PostsController@update');
Route::get('/{delete}/delete','PostsController@delete');
Route::get('/follow/{follow}','PostsController@follow');
Route::get('/unfollow/{unfollow}','PostsController@unfollow');
Route::get('/logout','Auth\LoginController@logout');

Route::get('/profile','UsersController@profile');
Route::post('/update/profile','UsersController@profile');

Route::get('/search','UsersController@search');
Route::post('/search','UsersController@search');

Route::get('/follow-list','FollowsController@followPost');
Route::get('/followProfile/{id}','FollowsController@followProfile');
Route::get('/follower-list','FollowsController@follower');
