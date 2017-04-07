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
