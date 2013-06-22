@extends('admin.master')

@section('admin_content')

<section>
<h1>Users</h1>

<div class="user-list row content-box">
<?php foreach ($users as $user): ?> 
  <div class="span12">
    <div class="row">
      <div class="span2">
        <img src="<?php echo $user->getAvatar(60); ?>" alt="" />
        <strong><?php echo $user->username; ?></strong>
      </div>
      <div class="span2 offset3">
        <div class="btn-group">
          <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
            Actions <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><?php echo link_to('admin/user/' . $user->id .'/permissions', 'Permissions'); ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php endforeach;  ?>
</div>
</section>

@stop
