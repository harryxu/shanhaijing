{{ Form::open(array('class' => 'form-horizontal')) }}

<div class="control-group">
  <label class="control-label" for="inputEmail">Email</label>
  <div class="controls">
    <input type="text" name="email" id="inputEmail" placeholder="Email">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputUsername">Username</label>
  <div class="controls">
    <input type="text" id="inputUsername" placeholder="Username">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="inputPassword">Password</label>
  <div class="controls">
    <input type="password" name="password" id="inputPassword" placeholder="Password">
  </div>
</div>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Register</button>
</div>

{{ Form::close() }}
