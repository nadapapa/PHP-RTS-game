
    <h1>Hello
        @if (Auth::check())
            {{Auth::user()->name}}
        @else
            guest
        @endif
    </h1>
