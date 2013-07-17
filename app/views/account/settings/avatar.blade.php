@extends('account.settings.master')

@section('settings-content')
<?php echo Form::open(); ?>
  <div ng-init="avatar_type='<?php echo $user->avatar == 'gravatar' ? 'gravatar' : 'upload'; ?>'">
    <label class="radio inline">
      <input type="radio" name="avatar-type" value="gravatar" ng-model="avatar_type" />Gravatar
    </label>
    <label class="radio inline">
      <input type="radio" name="avatar-type" value="upload" ng-model="avatar_type" />@lang('misc.upload')
    </label>
  </div>
  <div ng-show="avatar_type == 'gravatar'">
    <a href="https://gravatar.com/" target="_blank">Change your avatar at Gravatar.com.</a>
  </div>
  <div ng-show="avatar_type == 'upload'">
    <input type="file" name="file-avatar" />
  </div>
  <div class="form-actions">
    <button class="btn btn-primary" type="submit">@lang('misc.save')</button>
  </div>
<?php echo Form::close(); ?>
@stop
