@extends(Config::get('cpanel::views.layout'))

@section('header')
  <h3>
    <i class="icon-reorder"></i> @lang('misc.category')
  </h3>
@stop
@section('content')
  <div class="row">
    <div class="span12">
      {{ Former::horizontal_open_for_files(route('admin.category.store')) }}
      <div class="block">
        <p class="block-heading">@lang('misc.add_new_group')</p>
        <div class="block-body">
          {{ Former::xlarge_text('name', 'Name')->required()->autofocus() }}
          {{ Former::xlarge_text('slug', 'Slug')->required() }}
          {{ Former::xlarge_text('color', 'Color') }}
          {{ Former::textarea('description', 'Description')->class('span5')->rows(3) }}
          {{ Former::file('logo', 'Logo')->accept('image') }}
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">@lang('misc.save')</button>
            <a href="{{route('admin.category.index')}}" class="btn">Cancel</a>
          </div>
        </div>
      </div>
      {{ Former::close() }}
    </div>
  </div>
@stop
