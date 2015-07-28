<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\FileUploader;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'image', 'author_id'];

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function setImageAttribute($image)
    {
        if ($image instanceof UploadedFile) {
            $image = FileUploader::store($image);
        }
        $this->attributes['image'] = $image;
    }
}
