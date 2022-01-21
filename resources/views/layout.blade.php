<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@lang('xero-payroll-au-translations::xero-payroll-au.heading')</title>

</head>
<body class="font-sans antialiased">
<div>
    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

</div>

</body>
</html>
