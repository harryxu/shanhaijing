@extends(Config::get('cpanel::views.layout'))

@section('header')
  <h3>
    <i class="icon-user"></i>
    Users
  </h3>
@stop
@section('content')
  <div class="row">
    <div class="span12">
      {{ Former::horizontal_open(route('admin.users.permissions', array($user->id)))->method('PUT') }}
      <div class="block">
        <p class="block-heading">{{ $user->username }} User Permissions</p>
        <div class="block-body">
          {{ Former::checkboxes()->checkboxes($allPermissions)
                ->check($userPermissions) }}
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">@lang('misc.save')</button>
            <a href="{{route('admin.users.index')}}" class="btn">@lang('misc.cancel')</a>
          </div>
        </div>
      </div>
      {{ Former::close() }}
    </div>
  </div>
@stop
