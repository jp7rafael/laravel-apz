<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('articles', 'ArticlesController');
Route::resource('authors', 'AuthorsController');
Route::resource('articles.recommendations', 'RecommendationsController', ['only' => ['create', 'store']]);

Route::post('queue/receive', function () {
    Log::notice('[SQS-JOB] [request-header]', Request::header());
    Log::notice('[SQS-JOB] [request-body]', Request::header());
    return 'SQS-JOB';
});
