@extends('layouts.master')

@section('content')
<div class="topic-list-wrapper">
  <div class="action-links list-tools">
    <a class="btn btn-default" href="<?php echo url('topic/create'); ?>">
      <i class="icon-plus"></i> Create Topic
    </a>
  </div>

  <section>
  <table class="table table-hover topic-list">
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
            <div class="topic-title-wrap">
              <?php $url =  't/' . $topic->id. '#' . strtotime($topic->last_post_at); ?>
              <?php echo link_to($url, ' ', array('class' => 'topic-read-status')); ?>
              <img src="<?php echo $topic->user->getAvatar(20); ?>" alt="" />
              <?php echo link_to($url, $topic->title); ?>
            </div>
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
