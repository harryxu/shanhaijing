<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>shj</title>
    {{ HTML::style('vendor/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('vendor/Flat-UI/css/flat-ui.css') }}
    {{ HTML::style('css/style.css') }}
  </head>
  <body>
    <div class="navbar navbar-static-top">
      <div class="navbar-inner">
        <div class="container">
          <div class="nav-collapse collapse">
            <?php echo link_to('/', '山海经', array('class' => 'brand')); ?>
            <ul class="nav pull-right">
              <?php if (Sentry::check()): ?>
                <li><?php echo link_to('user/'.Sentry::getUser()->username, Sentry::getUser()->username); ?></li>
                <li><?php echo link_to('account/logout', 'Logout'); ?></li>
              <?php else: ?>
                <li><?php echo link_to('account/login', 'Login'); ?></li>
                <li><?php echo link_to('account/register', 'Register'); ?></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content container">
      @yield('content')
    </div>

    @section('scripts')
      <?php echo HTML::script('vendor/jquery/jquery-1.10.1.min.js'); ?>
    @show
  </body>
</html>
