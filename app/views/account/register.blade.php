@extends('layouts.master')

@section('content')
<section>
<h1>Register</h1>
{{ Form::open(array('class' => 'form-horizontal')) }}
<div class="control-group">
  <label class="control-label" for="inputEmail">Email</label>
  <div class="controls">
    <?php echo Form::text('email'); ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputUsername">Username</label>
  <div class="controls">
    <?php echo Form::text('username') ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <?php echo Form::password('password'); ?>
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Register</button>
</div>
{{ Form::close() }}
</section>
@stop
