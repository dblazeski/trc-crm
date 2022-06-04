<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" value="{{ csrf_token() }}" />
	<title>{{ config('app.name') }}</title>
	<link href="{{ mix('/css/app.css') }}" type="text/css" rel="stylesheet" />
</head>

<body class="antialiased text-gray-700" data-api-url="{{ url('api') }}">

    <div id="app" class="max-w-4xl mx-auto my-20">
        @yield('content')
    </div>

	<script src="{{ mix('/js/app.js') }}" type="text/javascript"></script>
</body>

</html>
