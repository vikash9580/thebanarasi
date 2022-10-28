<a href="{{ route('compare') }}" class="d-flex align-items-center text-reset">
    <span class="flex-grow-1">
        @if(Session::has('compare'))
            <span class="badge badge-primary badge-inline badge-pill" style="display:none;">{{ count(Session::get('compare'))}}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill"></span>
        @endif
        <span class="nav-box-text d-none d-xl-block">{{translate('Compare')}}</span>
    </span>
</a>