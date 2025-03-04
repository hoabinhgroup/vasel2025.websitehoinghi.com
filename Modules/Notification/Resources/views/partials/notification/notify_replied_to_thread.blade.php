@php
$post = app(\Modules\Post\Repositories\PostInterface::class)->find($notification->data['thread']['reference_id']);
@endphp

<a target="_blank" onClick="markNotificationAsRead();" href="/{{ $post->slug }}.html">	
    <div class="media">
      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
      <div class="media-body">
        <h6 class="media-heading"><span class="text-muted">{{ $notification->data['user']['name'] }} đã bình luận chủ đề</span> {{ $post->name }}</h6>
        <p class="notification-text font-small-3 text-muted">{{ $notification->data['thread']['body'] }} -  <small>
          <time class="media-meta text-muted" datetime="">{{ \Carbon\Carbon::parse($notification->data['thread']['created_at'])->diffForHumans() }}</time>
        </small></p>
       
      </div>
    </div>
</a>