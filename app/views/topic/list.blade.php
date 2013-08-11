@extends('layouts.master')

@section('content')
<div class="topic-list-wrapper">
  <div class="action-links list-tools clearfix">
    <ul class="nav nav-pills categories">
    <?php foreach($categories as $cate): ?>
      <li class="{{ (isset($category) && $category->id == $cate->id) ? 'active' : '' }}">
        {{ link_to('cate/' . $cate->slug, $cate->name, array()) }}</li>
    <?php endforeach; ?>
    </ul>
    <div class="buttons pull-right">
    <?php if (isset($category)): ?>
      <a href="{{ url('/') }}" class="btn btn-default">@lang('misc.view_all_topics')</a>
    <?php endif; ?>
      <a class="btn btn-primary" href="{{ url('topic/create') }}">
        <i class="icon-plus"></i> Create Topic
      </a>
    </div>
  </div>

  <section>
  <table class="table table-hover topic-list">
    <thead>
      <tr>
        <th>Topic</th>
        <th>Category</th>
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
              <img src="<?php echo $topic->user->getAvatar(); ?>" alt="" />
              <?php echo link_to($url, $topic->title); ?>
            </div>
          </td>
          <td><?php echo is_null($topic->category) ? 'None' 
                : link_to('cate/' . $topic->category->slug, $topic->category->name); ?></td>
          <td><?php echo $topic->user->username; ?></td>
          <td><?php echo $topic->posts_count; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </section>

  <?php echo $topics->links(); ?>
</div>

@stop
