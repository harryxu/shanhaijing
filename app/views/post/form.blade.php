@extends('layouts.master')

@section('content')
<section>
  <h1>Edit post</h1>
  <?php echo Form::open(array(
    'url' => 'post/'.$post->id, 
    'method' => 'PUT',
    'class' => 'topic-reply', 
    'data-validate' => 'parsley')); ?>
    @include('inc.form_error')
    <div class="controls">
      <div class="wmd-panel">
        <div id="wmd-button-bar"></div>
        <?php echo Form::textarea('body', $post->body, array(
          'placeholder' => 'Type topic body here.', 
          'class' => 'span9', 
          'id' => 'wmd-input',
          'data-required' => 'true',
        )); ?>
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Save</button>
  <?php echo Form::close(); ?>
</section>
@stop
