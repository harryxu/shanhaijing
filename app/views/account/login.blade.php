@extends('layouts.master')

@section('content')
<section>
<h1>Login</h1>
<?php echo Form::open(array('class' => 'form-horizontal', 'data-validate' => 'parsley')); ?>

@include('inc.form_error')

<?php if (Session::has('login_error')): ?>
<div class="alert alert-error">
  Login failed.
</div>
<?php endif;  ?>
<div class="control-group">
  <label class="control-label" for="inputEmail">Username or Email</label>
  <div class="controls">
    <?php echo Form::text('login', '', array('data-required' => 'true'));  ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <?php echo Form::password('password', array('data-required' => 'true'));  ?>
  </div>
</div>

<div class="control-group">
  <div class="controls">
    <label class="checkbox">
      <input name="remember" type="checkbox"> Remember me
    </label>
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Login</button>
</div>

<?php echo Form::close(); ?>
</section>
@stop
