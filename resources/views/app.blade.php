<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('layouts.head')
</head>
<body class="bg-secondary d-flex flex-column min-vh-100"">

<div id="app" class="{{$additionalClass}}">
    <menu class="main-menu">@include('layouts.menu')@show</menu>
    @include('layouts.content')@show
</div>
@include('layouts.footer')@show
</body>
</html>
