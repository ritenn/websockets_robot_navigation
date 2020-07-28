@extends('app', ['additionalClass' => 'app-center'])
@section('content')
    <manual-navigation-page :configuration-data="{{$configuration}}"/>
@endsection
@section('footer')@endsection
