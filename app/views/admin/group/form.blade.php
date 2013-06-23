@extends('admin.master')

@section('admin_content')
<section>
<h1><?php echo isset($group) ? 'Edit group: '. e($group->name) : 'Create group'; ?></h1>
<?php echo Form::open(array(
  'url' => isset($group) ? 'admin/group/' . $group->id : 'admin/group',
  'method' => isset($group) ? 'PUT' : 'POST',

)); ?>
  @include('inc.form_error')
  
  <div class="control-group">
    <label class="control-label">Group name</label>
    <div class="controls">
      <?php echo Form::text('name', isset($group) ? $group->name : ''); ?>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label">Permissions</label>
    <div class="controls">
      <?php echo Form::textarea('permissions', '', array('class' => 'span6')); ?>
    </div>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Save</button>
    <a class="btn" href="<?php echo url('admin/group'); ?>">Cancel</a>
  </div>
<?php echo Form::close(); ?>
</section>
@stop
