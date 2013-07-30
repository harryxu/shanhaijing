@extends(Config::get('cpanel::views.layout'))

@section('header')
  <h3>
    <i class="icon-wrench"></i>
    @lang('settings')
  </h3>
@stop

@section('content')
  <div class="row">
    <div class="span12">
      {{ Form::open(array('class' => 'form-horizontal')) }}
        <div class="block">
          <p class="block-heading">@lang('site-settings')</p>
          <div class="block-body">
            <div class="control-group">
              <label class="control-label" for="">Site name</label>
              <div class="controls">
                <?php echo Form::text('sitename', Variable::get('sitename')); ?>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      {{ Form::close() }}
    </div>
  </div>
@stop

