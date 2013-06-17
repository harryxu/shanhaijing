@extends('layouts.master')

@section('vendor-styles')
  @parent
  {{ HTML::style('vendor/pagedown/pagedown.css') }}
@stop

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
              <div class="post-header">
                <a class="username" href="<?php echo url('user/' . $post->user->username); ?>">
                  <strong><?php echo $post->user->username; ?></strong>
                </a>
                <span class="time">
                  <?php echo link_to('t/' . $topic->id . '#post-'.$post->id, time_passed($post->created_at)); ?>
                </span>
              </div>
              <?php echo filtertext($post->body); ?>
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
      <div class="wmd-panel">
        <div id="wmd-button-bar"></div>
        <?php echo Form::textarea('body', '', array(
          'placeholder' => 'Type topic body here.', 
          'class' => 'span', 
          'id' => 'wmd-input')); ?>
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Reply</button>
  <?php echo Form::close(); ?>

  @section('scripts')
    @parent
    <?php echo HTML::script('vendor/pagedown/Markdown.Converter.js'); ?>
    <?php echo HTML::script('vendor/pagedown/Markdown.Sanitizer.js'); ?>
    <?php echo HTML::script('vendor/pagedown/Markdown.Editor.js'); ?>
    <script type="text/javascript">
    (function() {
      var converter = Markdown.getSanitizingConverter();
      var editor = new Markdown.Editor(converter);
      editor.run();
    })();
    </script>
  @stop
  <?php endif; ?>
</div>

@stop
