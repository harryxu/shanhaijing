@extends(Config::get('cpanel::views.layout'))

@section('header')
  <h3>
    <i class="icon-reorder"></i> @lang('misc.category')
  </h3>
@stop
@section('content')
  <div class="row">
    <div class="span12">
      <?php if ($category->id == 0):  ?>
      {{ Former::horizontal_open_for_files(route('admin.category.store')) }}
      <?php else: ?>
      {{ Former::horizontal_open_for_files(route('admin.category.update', $category->id))->method('PUT') }}
      <?php endif;  ?>
      <div class="block">
        <p class="block-heading">@lang('misc.edit_category')</p>
        <div class="block-body">
          {{ Former::xlarge_text('name', 'Name')->value($category->name)->required()->autofocus() }}
          {{ Former::xlarge_text('slug', 'Slug')->value($category->slug)->required() }}
          {{ Former::xlarge_text('color', 'Color')->value($category->color) }}
          {{ Former::textarea('description', 'Description')->value($category->description)
                ->class('span5')->rows(3) }}
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
