<?php

namespace App\Queue;

use App;
use Queue;
use Request;

class PushedSqsQueue
{

    public function marshal()
    {
        try {
            $this->createPushedSqsJob()->fire();
        } catch (Exception $e) {
            Log::error('[SQS-JOB] Error: ' . $e->getMessage());
            return response($e->getMessage(), 500);
        }
        return response('OK');
    }
    
    protected function createPushedSqsJob()
    {
        $queue = Queue::connection();
        $jobData = ['Body' => json_encode(Request::all())];
        return new PushedSqsJob(App::getFacadeRoot(), $queue->getSqs(), $queue, $jobData);
    }
}
