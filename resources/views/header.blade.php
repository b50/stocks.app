<header>
    {{-- Css --}}
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">

    {{-- Scripts --}}
    <script src="http://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/jquery.marquee.min.js"></script>
    @yield('scripts')

    {{-- CSRF token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</header>