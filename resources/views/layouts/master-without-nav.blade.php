<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | Amicale 2.0 - SETER</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('images/seter-favicon.ico')}}">
        @include('layouts.head')
  </head>
    @yield('body')

    @yield('content')

    @include('sweetalert::alert')
    @include('layouts.footer-script')
    </body>
</html>
