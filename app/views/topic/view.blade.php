@extends('layouts.master')

@section('content')
<h1><?php echo $topic->title; ?></h1>
<div class="posts">
  <?php foreach ($topic->posts() as $post): ?>
    <div id="post-<?php echo $post->id ?>" class="post">
      <?php echo $post->body; ?>
    </div>
  <?php endforeach;  ?>
</div>
@stop
