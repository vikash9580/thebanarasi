
<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset">
    <span class="flex-grow-1">
        @if(Auth::check())
            <span class="badge badge-primary badge-inline badge-pill" style="display:none;">{{ count(Auth::user()->wishlists)}}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill"  style="display:none;"></span>
        @endif
        <span class="nav-box-text d-none d-xl-block">{{translate('Wishlist')}}</span>
    </span>
</a>

