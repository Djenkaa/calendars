<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="{{mix('css/all.css')}}">
    @yield('myCss')

    <!-- Styles -->

</head>

<body>
@include('sweetalert::alert')

<div id="app">

    @yield('content')

</div>


<script src="{{mix('js/app.js')}}"></script>
@yield('myJs')
</body>

</html>

