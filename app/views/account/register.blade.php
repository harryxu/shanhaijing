@extends('layouts.master')

@section('content')
<section>
<h1>Register</h1>
<?php echo Form::open(array('class' => 'form-horizontal', 'data-validate' => 'parsley')); ?>
@include('inc.form_error')
<div class="control-group">
  <label class="control-label" for="inputEmail">Email</label>
  <div class="controls">
  <?php echo Form::text('email', '', array('data-required' => 'true', 
                                           'data-type' => 'email')); ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputUsername">Username</label>
  <div class="controls">
    <?php echo Form::text('username', '', array('data-required' => 'true', 
                                                'data-type' => 'alphanum')); ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <?php echo Form::password('password', array('data-required' => 'true')); ?>
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Register</button>
</div>
<?php echo Form::close(); ?>
</section>
@stop
