<h1>Login</h1>
{{ Form::open(array('class' => 'form-horizontal')) }}

<?php if (Session::has('login_error')): ?>
<div class="alert alert-error">
  Login failed.
</div>
<?php endif;  ?>
<div class="control-group">
  <label class="control-label" for="inputEmail">Email</label>
  <div class="controls">
    <?php echo Form::text('email');  ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <?php echo Form::password('password');  ?>
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Login</button>
</div>

{{ Form::close() }}
