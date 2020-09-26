<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', 'HomeController');

Route::get('posts', 'PostController@index')->name('posts.index');

Route::prefix('posts')->middleware('auth')->group(function () {

    Route::get('create', 'PostController@create')->name('posts.create');
    Route::post('store', 'PostController@store');

    Route::get('{post:slug}/edit', 'PostController@edit');
    Route::patch('{post:slug}/edit', 'PostController@update');

    Route::delete('{post:slug}/delete', 'PostController@destroy');

});

Route::get('posts/{post:slug}', 'PostController@show');

Route::get('categories/{category:slug}', 'CategoryController@show');
Route::get('tags/{tag:slug}', 'TagController@show');


Route::view('contact', 'contact');
Route::view('about', 'about');
Route::view('login', 'login');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
