<?php


function s3Url($file_name)
{
    return env('S3_URL') . 'uploads/' . $file_name;
}
