<?php

namespace App\Jobs;

class FileTimeWriter
{
    public function fire($job, $data)
    {
        File::append(app_path().'/time.txt', $data['time'] . PHP_EOL);
    }
}
