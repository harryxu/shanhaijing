<?php foreach(Session::get('shj_messages', array()) as $msg): ?>
  <div class="alert alert-{{ $msg['type'] }}">{{ $msg['text'] }}</div>
<?php endforeach; ?>
