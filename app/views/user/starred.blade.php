@extends('user.master')

@section('user-content')

  <ul>
    <?php foreach ($topics as $topic): ?>
      <li>{{ link_to('t/' . $topic->id, $topic->title) }}</li>
    <?php endforeach; ?>
  </ul>

@stop
