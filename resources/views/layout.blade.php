<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'To-Do List')</title>
  <link  href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" >
</head>
<body>
  <div class="container mt-4">
    @yield('content')
  </div>

  <script  type="module" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <link  href="{{ asset('css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" >
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
  @stack('scripts')
</body>
</html>