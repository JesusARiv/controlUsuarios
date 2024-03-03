<!DOCTYPE html>
<html lang="mx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @routes()
    <title>@yield('title')</title>
    {{-- CSRF Token meta tag --}}
    <meta id='csrf' name='csrf-token' content='{{ csrf_token() }}'>
    {{-- Include modal --}}
    @include('modal.modal')
    <link rel="icon" href="{{ asset('img/utc_logo.png') }}">
    {{-- LIBRARIES --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/bootstrap/bootstrap.min.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/dataTables/dataTables.bootstrap5.min.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/dataTables/responsive.dataTables.min.css') }}">
    <!-- JAVASCRIPT -->
    <!-- Fontawesome -->
    <link rel='stylesheet' href="{{ asset('lib/fontawesome/css/fontawesome.css') }}">
    <link rel='stylesheet' href="{{ asset('lib/fontawesome/css/all.min.css') }}">
    <!-- JQUERY -->
    <script src='{{ asset('lib/jquery/jquery.min.js') }}' defer></script>
    <!-- BOOTSTRAP -->
    <script src='{{ asset('lib/bootstrap/bootstrap.bundle.min.js') }}' defer></script>
    <!-- SWEETALERT 2 -->
    <script src='{{ asset('lib/sweetalert/sweetalert2.all.min.js') }}' defer></script>
    <!-- Datatables -->
    <script src='{{ asset('lib/dataTables/datatables.min.js') }}' defer></script>
    <!-- Datatables Bootstrap 5-->
    <script src='{{ asset('lib/dataTables/dataTables.bootstrap5.min.js') }}' defer></script>
    <!-- DATATABLES SPANISH -->
    <script src='{{ asset('lib/dataTables/jquery.dataTables.spanish.js') }}' defer></script>
    <!-- Datatables Responsive-->
    <script src='{{ asset('lib/dataTables/dataTables.responsive.min.js') }}' defer></script>
    {{-- Currency --}}
    <script src="{{ asset('lib/currency/currency.js') }}" defer></script>
</head>

<body style="background-color: #27AE60">
    @yield('body')
</body>
<script>
    const setMethodHeaders = (method, body = []) => {
        switch (method) {
            case 'POST':
                return {
                    method,
                    body,
                    headers: {
                        'X-CSRF-TOKEN': $('#csrf').attr('content'),
                        Accept: 'application/json'
                    }
                }
                break;
            case 'PUT':
                return {
                    method,
                    body: JSON.stringify(Object.fromEntries(body)),
                        headers: {
                            'X-CSRF-TOKEN': $('#csrf').attr('content'),
                            Accept: 'application/json',
                            'Content-Type': 'application/json'
                        }
                }
                break;
            case 'DELETE':
                return {
                    method,
                    headers: {
                        'X-CSRF-TOKEN': $('#csrf').attr('content'),
                        Accept: 'application/json'
                    }
                }
        }
    }
</script>
@stack('scripts')

</html>
