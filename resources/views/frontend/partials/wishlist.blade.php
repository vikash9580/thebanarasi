
<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset">
    <span class="flex-grow-1">
        @if(Auth::check())
            <span class="badge badge-primary badge-inline badge-pill" style="display:none;">{{ count(Auth::user()->wishlists)}}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill"  style="display:none;"></span>
        @endif
        <i class="crt la la la-heart-o la-2x"></i>
    </span>
</a>


