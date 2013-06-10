<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>shj</title>
    {{ HTML::style('vendor/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('vendor/Flat-UI/css/flat-ui.css') }}
  </head>
  <body>
    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
