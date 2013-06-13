@extends('layouts.master')

@section('content')
<h1><?php echo $topic->title; ?></h1>
<div class="posts">
  <?php foreach ($topic->posts() as $post): ?>
    <div id="post-<?php echo $post->id ?>" class="post">
      <?php echo $post->body; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php if (Sentry::check()): ?> 
<?php echo Form::open(array('url' => 'topic/reply', 'class' => 'topic-reply')); ?>
  <h3>Reply</h3>
  <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>" />
  <div class="controls">
    <?php echo Form::textarea('body', '', array('class' => 'span')); ?>
  </div>
  
  <button type="submit" class="btn btn-primary">Reply</button>
<?php echo Form::close(); ?>
<?php endif; ?>

@stop
