<?php

use Illuminate\Queue\Jobs\SqsJob;

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
    $queue = Queue::connection();
    $jobData = ['Body' => json_encode(Request::all())];
    Log::notice('[SQS-JOB] [request-header]', $jobData);

    try {
        $job = new SqsJob(App::getFacadeRoot(), $queue->getSqs(), $queue, $jobData);
        $job->fire();
    } catch (Exception $e) {
        //The Receipt Handle is used to delete the message and we are not taking care of it.
        if ($e->getMessage() != 'Undefined index: ReceiptHandle') {
            Log::error('[SQS-JOB] Error: ' . $e->getMessage());
            return response($e->getMessage(), 500);
        }
    }
    return 'OK';
});

Route::get('/time', function () {
    return Queue::push(App\Jobs\FileTimeWriter::class, ['time' => time()]);
});
