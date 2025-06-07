<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/@fortawesome/fontawesome-free/css/all.min.css') }}">

        <!-- CSS Libraries -->

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    </head>
    <body>
        <div id="app">
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- General JS Scripts -->
        <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
        <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
        <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('library/nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('js/stisla.js') }}"></script>

        <!-- JS Libraies -->

        <!-- Page Specific JS File -->

        <!-- Template JS File -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    </body>
</html>
