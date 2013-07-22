@extends('layouts.master')

@section('vendor-styles')
  @parent
  {{ HTML::style('vendor/pagedown/pagedown.css') }}
  {{ HTML::style('vendor/select2/select2.css') }}
@stop

@section('content')
<section>
<h1><?php echo isset($topic) ? 'Edit topic: ' . e($topic->title) : 'Create Topic'; ?></h1>
<?php echo Form::open(array(
  'url' => isset($topic) ? 'topic/' . $topic->id : 'topic',
  'method' => isset($topic) ? 'PUT' : 'POST',
  'class' => 'form-horizontal',
  'data-validate' => 'parsley'
)); ?>
  @include('inc.form_error')
  <div class="control-group">
    <?php echo Form::text('title', isset($topic) ? $topic->title : '', array(
      'placeholder' => 'Type topic title here.', 
      'class' => 'span5',
      'data-required' => 'true'
    )); ?>

    <?php 
      $data_categories = array();
      foreach ($categories as $id => $cate) {
          $data_categories[$id] = $cate->name;
      }
      echo Form::select('category_id', $data_categories, 
              isset($topic) ? $topic->category_id : 0); 
    ?>
  </div>
  <div class="control-group">
    <div class="wmd-panel">
      <div id="wmd-button-bar"></div>
      <?php echo Form::textarea('body', isset($post) ? $post->body : '', array(
        'placeholder' => 'Type topic body here.', 
        'class' => 'span9', 
        'id' => 'wmd-input')); ?>
    </div>
  </div>

  <div class="control-group">
    <button type="submit" class="btn btn-primary">
      <?php echo isset($topic) ? 'Save' : 'Create Topic'; ?></button>
  </div>
<?php echo Form::close(); ?>
</section>
@stop

@section('scripts')
  @parent
  <?php echo HTML::script('vendor/pagedown/Markdown.Converter.js'); ?>
  <?php echo HTML::script('vendor/pagedown/Markdown.Sanitizer.js'); ?>
  <?php echo HTML::script('vendor/pagedown/Markdown.Editor.js'); ?>
  <?php echo HTML::script('vendor/select2/select2.min.js'); ?>
  <script type="text/javascript">
  (function() {
    var converter = Markdown.getSanitizingConverter();
    var editor = new Markdown.Editor(converter);
    editor.run();

    //$('select').select2({ width: 260 });
  })();
  </script>
@stop
