@extends($template)

@section('content')
  {!! Form::open(['route' => 'articles.store', 'data-remote' => $remote, 'files' => true]) !!}
      @include ('articles.form', ['submitButtonText' => 'Add Article'])
  {!! Form::close() !!}
@endsection
