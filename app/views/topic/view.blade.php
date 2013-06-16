@extends('layouts.master')

@section('content')
<div class="topic">
  <h1><?php echo $topic->title; ?></h1>
  <div class="posts">
    <?php foreach ($topic->posts() as $post): ?>
      <div id="post-<?php echo $post->id ?>" class="row">
        <div class="span9 post">
          <div class="row">
            <div class="avatar span1">
              <img src="<?php echo $post->user->getAvatar(40); ?>" alt="" />
            </div>
            <div class="body span8">
              <div class="author">
                <a class="username" href="<?php echo url('user/' . $post->user->username); ?>">
                  <strong><?php echo $post->user->username; ?></strong>
                </a>
              </div>
              <?php echo markdown($post->body); ?>
            </div>
          </div>
        </div>
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
</div>

@stop
