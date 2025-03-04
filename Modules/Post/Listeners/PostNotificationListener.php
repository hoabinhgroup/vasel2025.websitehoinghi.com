<?php

namespace Modules\Post\Listeners;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Post\Repositories\PostInterface;

class PostNotificationListener
{
  /**
   * @var PostInterface
   */
  protected $post;

  /**
   * RenderingSiteMapListener constructor.
   * @param PostInterface $postRepository
   * @param CategoryInterface $categoryRepository
   * @param TagInterface $tagRepository
   */
  public function __construct(PostInterface $post)
  {
    $this->post = $post;
  }

  /**
   * Handle the event.
   *
   * @return void
   */
  public function handle(CreatedContentEvent $event)
  {
    // sendSubcribeNotification($event->data);
    // $return["allresponses"] = $response;
    // $return = json_encode($return);
    // //
    // $data = json_decode($response, true);
    // dd($data);
  }
}
