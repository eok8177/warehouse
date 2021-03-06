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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="/css/app.css" rel="stylesheet">
  @yield('styles')

</head>

<body>
  <div id="app">

    @include('apteka.navbar')

    <div class="container-fluid">
      <div class="col-md-2">@include('apteka.sidebar')</div>

      <div class="col-md-10">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="/js/datepicker-uk.js"></script>
  @yield('scripts')
</body>

</html>