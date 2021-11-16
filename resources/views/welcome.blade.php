<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <app :key="$store.state.globalKey"/>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        @if(config('app.env') == 'local')
            <script src="http://127.0.0.1:35729/livereload.js"></script>
        @endif
    </body>
</html>
