@extends('layouts.master')

@section('content')
<section class="user-show">
  <div class="row user-head">
    <div class="span2">
      <img src="{{ $user->getAvatar(128) }}" alt="" />
    </div>
    <div class="span6">
      <span class="username">{{{ $user->username }}}</span>
    </div>
  </div>
</section>
@stop
