@extends('app', ['additionalClass' => 'app-center', 'title' => 'Manual navigation'])
@section('content')
    <manual-navigation-page :configuration-data="{{$configuration}}"/>
@endsection
@section('footer')@endsection
