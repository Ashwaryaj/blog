<!-- Navbar defined here -->
<div class="blog-masthead">
  <div class="container">
    <nav class="blog-nav">
      @if (Auth::check())
      	<a class="blog-nav-item" href="/">Hi {{ Auth::user()->name }}</a>
        <a class="blog-nav-item" href="/posts/create">Create Post</a>
        <a class="blog-nav-item pull-right" href="/logout">Logout</a>
      @else
        <a class="blog-nav-item" href="/">Home</a>
        <a class="blog-nav-item pull-right" href="/login">Login</a>
        <a class="blog-nav-item pull-right" href="/register">Register</a>      
      @endif
    </nav>
  </div>
</div>

    