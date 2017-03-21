@extends('layout')

@section('content')
	<div class="col-sm-8 blog-main">
		<h1> Edit your post </h1>
		<hr>
		<form method="POST"  action="/posts/{{$post->id}}">
		  {{ method_field('PATCH') }}
		  {{csrf_field()}}
		  <input name="_method" type="hidden" value="PATCH">
		  <div class="form-group">
		    <label for="title">Title </label>
		    <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}">
		  </div>
		  <div class="form-group">
		    <label for="body">Body</label>
		    <textarea name="body" id="body" class="form-control" >{{$post->body}}</textarea>
		  </div>
		  <div>
			  <div class="form-group">
			  	<button type="submit" class="btn btn-primary" name="status" value="published">Publish</button>
			  	<button  type="submit" class="btn btn-primary" name="status" value="draft">Draft</button>
			  </div>
		  </div>
		  <div class="form-group">
		  	 <a href="{{ route('posts.index') }}">Go back to all posts</a>
		  </div>
		  <div>
		    @include('layouts.errors')
		  </div>	
		</form>		
	</div>
@endsection