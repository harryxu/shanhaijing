@extends('admin.master')

@section('admin_content')

<section>
  <h1>User: <?php echo $user->username; ?></h1>
  <h2>Permissions</h2>
  <?php echo Form::open(); ?>
    <?php echo Form::textarea('permissions', $permissions, array(
            'class' => 'span6',
          )); ?>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Save permissions</button>
    </div>
  <?php echo Form::close(); ?>
</section>

@stop
