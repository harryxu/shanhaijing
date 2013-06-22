@extends('layouts.master')

@section('styles')
  @parent
  {{ HTML::style('css/admin.css') }}
@stop

@section('content')
<div class="row">
  <div class="span3 admin-side">
    <ul class="nav nav-list">
      <li><?php echo link_to('admin/settings', 'Site settings'); ?></li>
      <li><?php echo link_to('admin/user', 'Users'); ?></li>
    </ul>
  </div>
  <div class="span9">
    @yield('admin_content')
  </div>
</div>
@stop
