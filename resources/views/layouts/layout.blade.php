<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @include('partials.libraries')
    @yield('scripts')
</head>

<body>
    @include('partials.navbar')
    <div class="container mt-5 mb-5">
        @yield('body')
    </div>
</body>

</html>