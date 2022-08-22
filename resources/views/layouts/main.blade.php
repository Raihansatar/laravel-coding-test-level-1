<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    @include('layouts.style')

</head>
<body>
    <div>
        @include('layouts.header')

        @yield('content')
    </div>
    @include('layouts.script')
</body>
</html>
