@extends('layouts.master')

@section('content')
<div class="topic-list-wrapper">
  <div class="list-tools">
  <a class="btn btn-default" href="<?php echo url('topic/create'); ?>">
    <i class="icon-plus"></i> Create Topic
  </a>
  </div>

  <section>
  <table class="table table-bordered table-hover topic-list">
    <thead>
      <tr>
        <th>Topic</th>
        <th>Author</th>
        <th>Posts</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($topics as $topic): ?>
        <tr>
          <td>
            <img src="<?php echo $topic->user->getAvatar(20); ?>" alt="" />
            <?php echo link_to('t/' . $topic->id, $topic->title); ?>
          </td>
          <td><?php echo $topic->user->username; ?></td>
          <td><?php echo $topic->posts_count; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </section>
</div>

@stop
