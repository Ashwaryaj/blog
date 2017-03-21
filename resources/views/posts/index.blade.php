<!-- Rendering posts -->
@extends('layout')
@include('layouts.errors')
<?php
use Illuminate\Support\Facades\Input;
?>
@section('content')
	<div class="row">
		<div class="col-sm-8 blog-main"> 
			@foreach ($posts as $post)
			  	@include('posts.post')
			  	@if (Auth::check())
			  		<form  method="POST" action="/posts/{{$post->id}}" class="has-confirm" data-message="Delete this post?">
			  			{{method_field('DELETE')}} 
			  			{{csrf_field()}}
			  			@if($post->user_id==Auth::id())
				  			<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						@endif
					</form>  	
			  	@endif
			  	<hr>
		 	@endforeach
		 	<div class="pager"> {{ $posts->render() }} </div>
		</div><!-- /.blog-main -->
		<div>
			@include('layouts.sidebar')
		</div>
	</div><!-- /.row -->
@endsection