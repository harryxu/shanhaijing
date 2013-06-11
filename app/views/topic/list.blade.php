@extends('layouts.master')

@section('content')
<div class="topic-list-wrapper">
  <div class="list-tools">
  <a class="btn" href="<?php echo url('topic/create'); ?>">
    <i class="icon-plus"></i>Create Topic
  </a>
  </div>

  <table class="table table-bordered table-hover topic-list">
    <thead>
      <tr>
        <th>Topic</th>
        <th>Author</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($topics as $topic): ?>
        <tr>
          <td><?php echo link_to('t/' . $topic->id, $topic->title); ?></td>
          <td><?php echo $topic->user->email; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

@stop
