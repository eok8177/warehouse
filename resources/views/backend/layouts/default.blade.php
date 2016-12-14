<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="/css/app.css" rel="stylesheet">
  @yield('styles')
  <!-- Scripts -->
  <script>
    window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?>
  </script>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top">
      @include('backend.navbar')
    </nav>

    <div class="container-fluid">
      <div class="btn-group-vertical col-md-2" role="group" aria-label="...">
        <h3>Left menu</h3>
        <a href="{{ route('backend.dashboard') }}">Dashboard</a>
      </div>

      <div class="col-md-10">@yield('content')</div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  @yield('scripts')
</body>

</html>