@extends('user.master')

@section('user-content')

<div class="row">
  <div class="span5">
    <h2>Recent topics</h2>
    <ul>
      <?php foreach ($topics as $topic): ?>
        <li>{{ link_to('t/' . $topic->id, $topic->title) }}</li>
      <?php endforeach;  ?>
    </ul>
  </div>
  <div class="span5">
    <h2>Recent posts</h2>
  </div>
</div>

@stop
