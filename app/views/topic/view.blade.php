@extends('layouts.master')

@section('title')
{{{ $topic->title }}} - @parent @stop

@section('vendor-styles')
  @parent
  {{ HTML::style('vendor/pagedown/pagedown.css') }}
  {{ HTML::style('vendor/At.js/css/jquery.atwho.css') }}
@stop

@section('content')


<div class="topic">

  <div class="row">
  <div class="span10">
      <ul class="breadcrumb">
        <li>{{ link_to('/', Variable::get('sitename')) }}
      <?php if ($topic->category): ?>
        <span class="divider">/</span></li>
        <li>{{ link_to('cate/' . $topic->category->slug, $topic->category->name) }}</li>
      <?php endif; ?>
      </ul>
    <section>
      <h1><?php echo $topic->title; ?></h1>
      <?php $posts = $topic->posts(); ?>
      <?php $post = $posts->shift();  ?>
      <div id="post-<?php echo $post->id ?>" class="row anchorfix">
        <div class="span9 post first">
          @include('topic.post')
        </div>
      </div>
    </section>

  <?php if (!$posts->isEmpty()): ?>
    <section>
      <div class="posts">
        <?php foreach ($posts as $post): ?>
          <div id="post-<?php echo $post->id ?>" class="row anchorfix">
            <div class="span9 post">
              @include('topic.post')
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php else: ?>
    <div class="no-replies">@lang('misc.no_replies')</div>
  <?php endif; ?>

  <?php if (Sentry::check()): ?>
    <section class="reply-form" name="reply">
    <?php echo Form::open(array('url' => 'post', 'class' => 'topic-reply', 'data-validate' => 'parsley')); ?>
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
  </div>

  @section('scripts')
    @parent
    <?php echo HTML::script('vendor/At.js/js/jquery.atwho.min.js'); ?>
    <?php echo HTML::script('vendor/pagedown/Markdown.Converter.js'); ?>
    <?php echo HTML::script('vendor/pagedown/Markdown.Sanitizer.js'); ?>
    <?php echo HTML::script('vendor/pagedown/Markdown.Editor.js'); ?>
    <script>
    (function() {
      var converter = Markdown.getSanitizingConverter();
      var editor = new Markdown.Editor(converter);
      editor.run();

      $(function() {
        $('#wmd-input').atwho({
          at: "@",
          search_key: 'username',
          data: shanhaijing.settings.topic.postedUsers,
          tpl: "<li data-value='${username}'>${username} </li>"
        });
      });
    })();
    </script>
  @stop
  <?php endif; ?>
</div>
</div>

@stop
