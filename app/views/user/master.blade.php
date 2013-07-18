@extends('layouts.master')

@section('content')
<section class="user-show">
  <div class="row user-head">
    <div class="span2">
      <img src="{{ $user->getAvatar('b') }}" alt="" />
    </div>
    <div class="span6">
      <span class="username">{{{ $user->username }}}</span>
      <?php if (Sentry::check() && Sentry::getUser()->id == $user->id): ?>
        <p>{{ link_to('user/' . $user->username. '/settings', 'Account settings') }}</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<section>
  <?php 
    $base_path = 'user/' . $user->username;
    $menu = Menu::handler('user_menu', array('class' => 'nav nav-tabs'))
      ->add($base_path, 'Overview');
    if (Sentry::check() && Sentry::getUser()->id == $user->id) {
        $menu->add($base_path . '/starred', 'Starred');
    }
    echo $menu;
  ?>
  
  @yield('user-content')
</section>
@stop
