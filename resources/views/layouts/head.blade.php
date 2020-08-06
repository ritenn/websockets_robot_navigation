<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
@isset($title)
    {{ $title }} |
@endisset
{{ config('app.name') }}
</title>

<link rel="icon" type="image/png" href="{{ asset('icon.png') }}"/>

<!-- Stylesheets -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@section('top_css_stylesheets')
@show
<!-- JS scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@section('top_js_scripts')
@show
