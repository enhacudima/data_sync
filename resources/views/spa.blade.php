<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}"/>
        <link rel="icon" type="image/jpg" href="{{URL::asset('/storage/icons/icon.png')}}"/>
        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <title>Concurso Público</title>
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
