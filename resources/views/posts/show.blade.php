<?php
use App\User;
?>
@extends('layout')
@section('content')
	<div class="col-sm-8 blog-main">
		<h1> {{ $post->title }} </h1>
		@if(count($post->tags))
			<ul id="all-tags">
				@foreach($post->tags as $tag)
					<li class="label label-primary">
						<a href="/posts/tags/{{ $tag->name }}" class="show-tags">
							{{ $tag->name }}
						</a>
					</li>
				@endforeach
			</ul>
		@endif
		{{$post->body}}
		<hr>
		<!-- Show comments -->
		<div class="comments">
			<ul class="list-group">
				@foreach ( $post->comments as $comment )
					<li class="list-group-item">
						<strong>
							{{ $comment->created_at->diffForHumans() }}
						</strong>
						by 
						<?php
						$user=User::select('name')->where('id',$comment->user_id )->first();
						?>
						<i>
							{{ $user['name'] }}
						</i>	
						<br>
						{{ $comment->body }}
					</li>
				@endforeach
			</ul>
		</div>
		<hr>
		<!-- A place to add comments -->
		@if (Auth::check())
			<div class="card">
				<div class="card-block">
					<form method="POST" action="/posts/{{ $post->slug }}/comments">
						{{csrf_field()}}
						<div class="form-group">
							<textarea name="body" placeholder="Your comment here." class="form-control" id="comment"></textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary ">Add comment</button>
						</div>
					</form>
				</div>
			</div>
		@endif
	</div>
@endsection