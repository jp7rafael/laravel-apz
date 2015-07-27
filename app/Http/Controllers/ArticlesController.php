<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use App\Article;
use App\Author;
use File;
use Storage;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::all();

        if (Request::wantsJson()) {
            return $articles;
        } else {
            return view('articles.index', compact('articles'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $article = new Article;
        $authors = Author::lists('name', 'id')->all();

        return view('articles.create', compact('article', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $request['image_name'] = $this->saveImage($request);
        $article = Article::create($request->all());
        session()->flash('flash_message', 'Article was stored with success');

        if (Request::wantsJson()) {
            return $article;
        } else {
            return redirect('articles');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Article $article)
    {
        if (Request::wantsJson()) {
            return $article;
        } else {
            return view('articles.show', compact('article', 'imagePath'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Article $article)
    {
        $authors = Author::lists('name', 'id')->all();

        return view('articles.edit', compact('article', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $request['image_name'] = $this->saveImage($request);
        $article->update($request->all());
        session()->flash('flash_message', 'Article was updated with success');
        
        if (Request::wantsJson()) {
            return $article;
        } else {
            return redirect('articles');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Article $article)
    {
        $deleted = $article->delete();
        session()->flash('flash_message', 'Article was removed with success');

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('articles');
        }
    }

    private function saveImage(ArticleRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getFilename() . '.' . $image->getClientOriginalExtension();
            Storage::put('uploads/' . $image_name, File::get($image), 'public');
            return $image_name;
        }
    }
}
