@extends('layouts.master')

@section('content')
<div class="row">
  <div class="span3">
    <ul class="nav nav-tabs nav-stacked">
      <li><?php echo link_to('admin/settings', 'Site settings'); ?></li>
      <li><?php echo link_to('admin/users', 'Users'); ?></li>
    </ul>
  </div>
  <div class="span9">
    @yield('admin_content')
  </div>
</div>
@stop
