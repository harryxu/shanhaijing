@extends('layouts.master')

@section('title')<?php echo $topic->title; ?> - @parent @stop

@section('vendor-styles')
  @parent
  {{ HTML::style('vendor/pagedown/pagedown.css') }}
@stop

@section('content')
<div class="topic">
  <section>
  <h1><?php echo $topic->title; ?></h1>
  <div class="posts">
      <p></p>
    <?php foreach ($topic->posts() as $post): ?>
      <div id="post-<?php echo $post->id ?>" class="row anchorfix">
        <div class="span9 post">
          @include('topic.post')
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  </section>

  <?php if (Sentry::check()): ?> 
  <section class="reply-form">
  <?php echo Form::open(array('url' => 'topic/reply', 'class' => 'topic-reply', 'data-validate' => 'parsley')); ?>
    <h3>Reply</h3>
    <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>" />
    <div class="controls">
      <div class="wmd-panel">
        <div id="wmd-button-bar"></div>
        <?php echo Form::textarea('body', '', array(
          'placeholder' => 'Type topic body here.', 
          'class' => 'span9', 
          'id' => 'wmd-input',
          'data-required' => 'true',
        )); ?>
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary">Reply</button>
  <?php echo Form::close(); ?>
  </section>

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
