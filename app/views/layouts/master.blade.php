<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>shj</title>
    {{ HTML::style('vendor/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('vendor/Flat-UI/css/flat-ui.css') }}
  </head>
  <body>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <?php if (Sentry::check()): ?>
                <li><?php echo HTML::link('account/logout', 'Logout'); ?></li>
              <?php else: ?>
                <li><?php echo HTML::link('account/login', 'Login'); ?></li>
                <li><?php echo HTML::link('account/register', 'Register'); ?></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
