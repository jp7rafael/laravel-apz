@extends($template)

@section('content')
  <article>
      <h1>{{ $article->title }}</h1>
      <div><img class="pull-left" src={{ uploads($article->image) }} ></div>
      <div>{{ $article->content }}</div>
      <div>{{ $article->author->name }}</div>
  </article>
  {!! link_to_route('articles.index', 'Articles') !!}
@endsection
