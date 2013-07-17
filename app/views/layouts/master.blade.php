<!DOCTYPE html>
<html ng-app>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo asset('favicon.ico'); ?>" type="image/x-icon" />
    <title>@section('title') 
{{ Variable::get('sitename') }}@show</title>
    @section('vendor-styles')
      {{ HTML::style('vendor/bootstrap/css/bootstrap.css') }}
      {{ HTML::style('vendor/bootplus/css/bootplus.css') }}
      {{ HTML::style('vendor/font-awesome/css/font-awesome.min.css') }}
      <!--[if IE 7]>
        {{ HTML::style('vendor/font-awesome/css/font-awesome-ie7.min.css') }}
      <![endif]-->
    @show
    @section('styles')
      {{ HTML::style('css/style.css') }}
    @show
    <!--[if lt IE 9]>
      <?php echo HTML::script('vendor/html5shiv/html5shiv-printshiv.js'); ?>
    <![endif]-->
  </head>
  <body>
    <div class="page-wrap">
      <div class="navbar navbar-static-top navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <div class="nav-collapse collapse">
              <?php echo link_to('/', '山海经', array('class' => 'brand')); ?>
              <form class="navbar-search">
                <input type="text" class="search-query" placeholder="Search">
              </form>
              <div class="pull-right">
                <ul class="nav">
                  <?php if (Sentry::check()): ?>

                  <li class="dropdown notification num{{ $notification->totalCount }}">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="icon-bell"></i> <span>{{ $notification->totalCount }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <?php if ($notification->totalCount > 0): ?>
                        <?php foreach ($notification->items as $noti): ?>
                          <li><?php echo link_to('notification/' . $noti->id, $noti->msg); ?></li>
                        <?php endforeach; ?>
                        <li class="divider"></li>
                        <li><a href="{{ url('notification/markallasread'); }}?_token={{ csrf_token(); }}">
                          <i class="icon-ok"></i> Mark all as read</a></li>
                      <?php endif; ?>
                      <li><a href="#"><i class="icon-eye-open"></i> View all notifications</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="<?php echo url('user/'.Sentry::getUser()->username); ?>">
                      <img src="<?php echo Sentry::getUser()->getAvatar(20); ?>" alt="" />
                      {{{ Sentry::getUser()->username }}}
                    </a>
                  </li>
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
      </div>

      <div class="container page-content">
        <?php if (Sentry::check()):  ?>
        <div id="notification-permission-request" class="notification-permission-request alert alert-block fade in">
          <button type="button" class="close" data-dismiss="alert">×</button>
          <h4 class="alert-heading">Enable desktop notification.</h4>
          <p>Desktop notification will notify you when their got new posts in your participated topics.</p>
          <p> </p>
          <button class="btn btn-primary enable" >Enable</button> <button data-dismiss="alert" class="btn">Dismiss</button>
        </div>
        <?php endif;  ?>
        @yield('content')
      </div>
      <div class="page-wrap-push"></div>
    </div>
    <footer class="footer">
      <div class="container">
        <p>Shanhaijing is a {{ link_to('opensource', 'open source') }} forum appliaction.</p>
        <p>The source code is hosted on <a href="https://github.com/harryxu/shanhaijing" target="_blank">github</a>.</p>
        <p>Sponsored by <a href="http://bigecko.com" target="_blank">bigecko.com</a></p>
      </div>
    </footer>

    @section('scripts')
      <?php echo HTML::script('vendor/jquery/jquery-1.10.1.min.js'); ?>
      <?php echo HTML::script('js/shanhaijing.js'); ?>
      <script type="text/javascript">
        jQuery.extend(shanhaijing.settings, <?php 
          $js = shanhaijing_add_js(); echo json_encode($js['settings']); ?>);
      </script>
      <?php if (Sentry::check()) echo HTML::script('js/notification.js'); ?>
      <?php echo HTML::script('vendor/bootstrap/js/bootstrap.min.js'); ?>
      <?php echo HTML::script('vendor/parsleyjs/parsley.js'); ?>
      <?php echo HTML::script('vendor/angularjs/angular.min.js'); ?>
    @show
  </body>
</html>
