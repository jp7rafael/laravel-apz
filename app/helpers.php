<?php

function uploads($file)
{
    return config('uploads.url') . $file;
}
