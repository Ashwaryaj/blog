<!-- Rendering posts -->
@extends('layout')
@section('content')
	<div class="row">
		<div class="col-sm-8 blog-main"> 
		  @foreach ($posts as $post)
		  	@include('posts.post')
		  @endforeach
		  <nav>
		    <ul class="pager">
		      <li><a href="#">Previous</a></li>
		      <li><a href="#">Next</a></li>
		    </ul>
		  </nav>
		</div><!-- /.blog-main -->
		<div>
			@include('layouts.sidebar')
		</div>
	</div><!-- /.row -->
@endsection