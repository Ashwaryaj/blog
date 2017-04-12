<!-- Form for creating post -->
@extends('layout')
@section('content')
	<div class="col-sm-8 blog-main">
		<h1> Publish a post </h1>
		<hr>
		<form method="POST" id="myFrm" action="/posts">
		  {{ csrf_field() }}
		  <div class="form-group">
		    <label for="title">Title </label>
		    <input type="text" class="form-control" id="title" name="title" value={{ old('title') }} >
		  </div>
		  <div class="form-group">
		    <label for="body">Body</label>
		    <textarea name="body" id="body" class="form-control" value={{ old('body') }} ></textarea>
		  </div>
		  <div class="form-group">
			<label>Add Tags</label><br/>
			<input type="text" name="tags" placeholder="Tags" class="typeahead tm-input form-control tm-input-info" id="tags" autocomplete="off" / >
		  </div>
		  <hr>
		  <div class="form-group">
		  	<button type="submit" class="btn btn-primary publish" name="status" value="published">Publish</button>
		  	<button type="submit" class="btn btn-primary draft"  name="status" value="draft">Draft</button>
		  </div>
		  <div>
		    @include('layouts.errors')
		  </div>
		</form>
	</div>
@endsection
