@extends('layouts.master')
@section('content')
  <section>
    <?php
    $base_path = 'user/' . $user->username;
    echo Menu::handler('accoun_settings', array('class' => 'nav nav-tabs'))
      ->add($base_path . '/settings', 'Account settings')
      ->add($base_path . '/settings/changepass', 'Change password')
      ->add($base_path . '/settings/avatar', 'Avatar');
    ?>
    
    @include('inc.form_error')
    @yield('settings-content')
  </section>
@stop
