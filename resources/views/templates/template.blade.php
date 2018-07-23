<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>VPoll</title>

        @yield('before-css')
        <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
        <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{url('css/summernote.css')}}" rel="stylesheet">
        <link href="{{url('css/select2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/custom.css')}}">
        @yield('after-css')
    </head>
    <body>
        <div id="app">
                <div class="container">
                    @yield('content')
                </div><!-- container -->
        </div><!-- #app -->

        <!-- Scripts -->
        @yield('before-scripts')
        <script src="{{url('js/jquery-3.3.1.min.js')}}"></script>
        <script src="{{url('js/popper.min.js')}}"></script>
        <script src="{{url('js/bootstrap.min.js')}}"></script>
        <script src="{{url('js/moment.min.js')}}"></script>
        <script src="{{url('js/summernote.min.js')}}"></script>
        <script src="{{url('js/select2.js')}}"></script>
        @yield('after-scripts')

    </body>
</html>
