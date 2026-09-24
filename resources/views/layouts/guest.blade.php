<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Butik Dayu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="no-hero min-h-screen overflow-x-hidden bg-gradient-to-br from-brand-100 via-cream to-brand-50 flex items-center justify-center px-4 py-12">

    @yield('content')

</body>
</html>
