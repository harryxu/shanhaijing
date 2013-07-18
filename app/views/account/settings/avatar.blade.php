@extends('account.settings.master')

@section('settings-content')
<?php echo Form::open(array('method' => 'PUT', 'files' => true)); ?>
  <div>
    <img src="{{ Sentry::getUser()->getAvatar('b') }}" alt="" />
    <img src="{{ Sentry::getUser()->getAvatar('s') }}" alt="" />
    <img src="{{ Sentry::getUser()->getAvatar('t') }}" alt="" />
  </div>
  <div ng-init="avatar_type='{{ $avatar_type }}'">
    <label class="radio inline">
      <input type="radio" name="avatar_type" value="gravatar" ng-model="avatar_type" />Gravatar
    </label>
    <label class="radio inline">
      <input type="radio" name="avatar_type" value="upload" ng-model="avatar_type" />@lang('misc.upload')
    </label>
  </div>
  <fieldset ng-show="avatar_type == 'gravatar'">
    <legend>Gravatar</legend>
    <a href="https://gravatar.com/" target="_blank">Change your avatar at Gravatar.com.</a>
  </fieldset>
  <fieldset ng-show="avatar_type == 'upload'">
    <legend>@lang('misc.upload')</legend>
    <input type="file" name="img" />
  </fieldset>
  <div class="form-actions">
    <button class="btn btn-primary" type="submit">@lang('misc.save')</button>
  </div>
<?php echo Form::close(); ?>
@stop
