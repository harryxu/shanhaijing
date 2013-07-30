@extends('account.settings.master')

@section('settings-content')
{{ Former::horizontal_open(Request::url())->method('PUT') }}
  {{ Former::password('oldpassword', 'misc.old_password')->autofocus() }}
  {{ Former::password('newpassword', 'misc.new_password') }}
  {{ Former::actions(Former::primary_button('misc.submit')->type('submit')) }}
{{ Former::close() }}
@stop
