@if(Breadcrumbs::has(Route::currentRouteName()))
<nav class="breadcrumb bg-white push">
    @foreach (Breadcrumbs::current() as $crumbs)
        @if ($crumbs->url() && !$loop->last)
            <a class="breadcrumb-item" href="{{ $crumbs->url() }}">{{ $crumbs->title() }}</a>                                
        @else
            <span class="breadcrumb-item active">{{ $crumbs->title() }}</span>                                
        @endif
    @endforeach
</nav>
@endif