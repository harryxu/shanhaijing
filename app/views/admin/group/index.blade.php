@extends('admin.master')

@section('admin_content')
<section>
<h1>Groups</h1>

<div class="action-links">
  <a href="<?php echo url('admin/group/create'); ?>" class="btn">
    <i class="icon-plus"></i> Add group</a>
</div>
<table class="table">
  <?php foreach ($groups as $group): ?>
  <tr>
    <td><strong>{{{ $group->name }}}</strong></td>
    <td><?php echo link_to('admin/group/' . $group->id . '/edit', 'Edit'); ?></td>
  </tr>
  <?php endforeach;  ?>
</table>
</section>
@stop
