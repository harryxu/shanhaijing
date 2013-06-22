<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@section('title') 
{{ Variable::get('sitename') }}@show</title>
    @section('vendor-styles')
      {{ HTML::style('vendor/bootstrap/css/bootstrap.css') }}
      {{ HTML::style('vendor/bootplus/css/bootplus.css') }}
    @show
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
    <footer class="footer">
      <div class="container">
        <p>Shanhaijing is a opensource forum appliaction.</p>
        <p>The source code is hosted on <a href="https://github.com/harryxu/shanhaijing" target="_blank">github</a>.</p>
        <p>Sponsored by <a href="http://bigecko.com" target="_blank">bigecko.com</a></p>
      </div>
    </footer>

    @section('scripts')
      <?php echo HTML::script('vendor/jquery/jquery-1.10.1.min.js'); ?>
      <?php echo HTML::script('vendor/bootstrap/js/bootstrap.min.js'); ?>
    @show
  </body>
</html>
