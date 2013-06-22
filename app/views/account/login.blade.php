@extends('layouts.master')

@section('content')
<section>
<h1>Login</h1>
{{ Form::open(array('class' => 'form-horizontal')) }}

<?php if (Session::has('login_error')): ?>
<div class="alert alert-error">
  Login failed.
</div>
<?php endif;  ?>
<div class="control-group">
  <label class="control-label" for="inputEmail">Username or Email</label>
  <div class="controls">
    <?php echo Form::text('login');  ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <?php echo Form::password('password');  ?>
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

{{ Form::close() }}
</section>
@stop
