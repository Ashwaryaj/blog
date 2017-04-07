<!-- Displaying a single post with title and created at and by whom-->
<div class="blog-post">
    <h2 class="blog-post-title">
    	<a href="/posts/{{$post->slug}}">
    		{{ $post->title }}
    	</a>
    </h2>
    @include('posts.tag')
    <p class="blog-post-meta">
    	{{ $post->user->name }} on
    	{{ $post->created_at->toFormattedDateString() }}
    </p>
    {!!$post->body!!}
</div>
