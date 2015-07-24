<?php

namespace App\Queue;

use Illuminate\Queue\Jobs\SqsJob;

class PushedSqsJob extends SqsJob
{
    public function delete()
    {
        $this->deleted = true;
    }
}
