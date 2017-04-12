<!-- Rendering posts -->
@extends('layout')
@include('layouts.errors')
@section('content')
	<div class="row">
		<div class="col-sm-8 blog-main">
			@foreach ($posts as $post)
			  	@include('posts.post')
			  	@if (Auth::check())
			  		<form  method="POST" action="/posts/{{$post->slug}}" class="has-confirm" data-message="Delete this post?">
			  			{{ method_field('DELETE') }}
			  			{{  csrf_field( )}}
			  			@if($post->user_id==Auth::id())
				  			<a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-primary">Edit Post</a>
							<button type="submit" class="btn btn-danger">Delete</button>
							<div class="social-buttons">
							    <a href="/facebookshare/{{ $post->title }}" target="_blank">
							       <i class="fa fa-facebook-official"></i>
							    </a>
								<a href="/twittershare/{{ $post->title }}" target="_blank" id="twitter">
							        <i class="fa fa-twitter-square"></i>
							    </a>
							    <a href="/gplusshare/{{ $post->title }}" target="_blank" id="gplus">
							       <i class="fa fa-google-plus-square"></i>
							    </a>
							</div>
						@endif
					</form>
			  	@endif
			  	<hr>
		 	@endforeach
<!-- 		 	<div class="pager"> {{ $posts->links() }} </div>-->
				<div class="pager">@include('pagination', ['paginator' => $posts])</div>
		</div><!-- /.blog-main -->
		<div>
			@include('layouts.sidebar')
		</div>
	</div><!-- /.row -->
@endsection
