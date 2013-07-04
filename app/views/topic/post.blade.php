<?php $topic = isset($topic) ? $topic : $post->topic; ?>
<div class="row">
  <div class="avatar span1">
    <img src="<?php echo $post->user->getAvatar(40); ?>" alt="" />
  </div>
  <div class="body span8">
    <div class="post-header clearfix">
      <a class="username" href="<?php echo url('user/' . $post->user->username); ?>">
        <strong><?php echo $post->user->username; ?></strong>
      </a>
      <div class="post-meta">
        <span class="time">
          <?php echo link_to('t/' . $topic->id . '#post-'.$post->id, time_passed($post->created_at)); ?>
        </span>
        <?php if (Sentry::check()): ?>
        <div class="btn-group">
          <a class="btn btn-link dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-reply"></i> Reply</a></li>
            <?php if ($post->user_id == Sentry::getUser()->id || Sentry::getUser()->hasAccess('topic.manage')):  ?>
            <li><a href="<?php echo $post->id == $topic->first_post_id ? url('topic/' . $topic->id . '/edit') : url('post/' . $post->id . '/edit'); ?>"><i class="icon-edit"></i> Edit</a></li>
            <li><a href="<?php echo $post->id == $topic->first_post_id ? url('topic/' . $topic->id . '/delete') : url('post/' . $post->id . '/delete'); ?>"><i class="icon-remove"></i> Delete</a></li>
            <?php endif; ?>
          </ul>
        </div>
        <?php endif;  ?>
      </div>
    </div>
    <?php echo filtertext($post->body); ?>
    <div class="post-footer clearfix">
      <div class="tools">
        <?php if ($topic->first_post_id == $post->id):  ?>
          <a class="auth" href="{{ url("topic/$topic->id/star") }}?_token={{ csrf_token() }}"><i class="icon-star-empty"></i></a>
          <a class="auth <?php echo $topicUser->watching ? 'watching' : ''; ?>" href="{{ url("topic/$topic->id/watch") }}?_token={{ csrf_token() }}"><i class="icon-eye-open"> @lang('misc.watch_topic')</i></a>
        <?php endif; ?>
        <a class="auth" href="#"><i class="icon-reply"> @lang('misc.reply')</i></a>
      </div>
    </div>
  </div>
</div>
