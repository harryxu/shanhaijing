@extends(Config::get('cpanel::views.layout'))

@section('header')
  <h3>
    <i class="icon-reorder"></i> @lang('misc.category')
  </h3>
@stop

@section('content')
<div class="row">
  <div class="span12">
    <div class="block">
      <p class="block-heading">@lang('misc.categories')</p>
      <div class="block-body">
        <div class="btn-toolbar">
          <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
            <i class="icon-plus"></i> @lang('misc.create_category')
          </a>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>@lang('misc.name')</th>
              <th>@lang('misc.action')</th>
            </tr>
            <tbody>
            <?php foreach ($categories as $cate): ?>
              <tr>
                <td>{{{ $cate->name }}}</td>
                <td>
                  <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                      Action <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="{{ route('admin.category.edit', array($cate->id)) }}">
                        <i class="icon-edit"></i>&nbsp;@lang('misc.edit')
                      </a></li>
                     <li><a href="{{ route('admin.category.destroy', array($cate->id)) }}"
                       data-method="delete" data-modal-text="delete this Category?">
                       <i class="icon-trash"></i>&nbsp;@lang('misc.delete')
                      </a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@stop
