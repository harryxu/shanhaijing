@extends('admin.master')

@section('admin_content')

<h1>Site settings</h1>

{{ Form::open(array('class' => 'form-horizontal')) }}
  <div class="control-group">
    <label class="control-label" for="">Site name</label>
    <div class="controls">
      <?php echo Form::text('sitename', Variable::get('sitename')); ?>
    </div>
  </div>
  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
{{ Form::close() }}

@stop
