@extends('layouts.master')

@section('content')
<h1>Create Topic</h1>
<?php echo Form::open(array()); ?>
  <div class="controls">
    <?php echo Form::text('title', '', array(
      'placeholder' => 'Type topic title here.', 'class' => 'span5')); ?>
    <?php echo Form::textarea('body', '', array(
      'placeholder' => 'Type topic body here.', 'class' => 'span')); ?>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Create Topic</button>
  </div>
<?php echo Form::close(); ?>
@stop
