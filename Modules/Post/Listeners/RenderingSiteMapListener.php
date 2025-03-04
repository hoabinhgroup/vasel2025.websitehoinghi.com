<?php

namespace Modules\Post\Listeners;

use Modules\Post\Repositories\CategoriesInterface;
use Modules\Post\Repositories\PostInterface;
use Modules\Post\Repositories\TagInterface;
use SiteMapManager;

class RenderingSiteMapListener
{
  /**
   * @var PostInterface
   */
  protected $post;

  /**
   * @var CategoryInterface
   */
  protected $category;

  /**
   * @var TagInterface
   */
  protected $tag;

  /**
   * RenderingSiteMapListener constructor.
   * @param PostInterface $postRepository
   * @param CategoryInterface $categoryRepository
   * @param TagInterface $tagRepository
   */
  public function __construct(
    PostInterface $post,
    CategoriesInterface $category,
    TagInterface $tag
  ) {
    $this->post = $post;
    $this->category = $category;
    $this->tag = $tag;
  }

  /**
   * Handle the event.
   *
   * @return void
   */
  public function handle()
  {
    $posts = $this->post->allBy(['status' => 'published']);
   
    foreach ($posts as $post) {
      SiteMapManager::add(
        request()->getSchemeAndHttpHost() . '/' . $post->slug->key . '.html',
        $post->updated_at,
        '0.8',
        'daily'
      );
    }

    $categories = $this->category->allBy(['status' => 'published']);

    foreach ($categories as $category) {
      SiteMapManager::add(
        request()->getSchemeAndHttpHost() . '/' . $category->slug->key,
        $category->updated_at,
        '0.8',
        'daily'
      );
    }
    //
    //     $tags = $this->tag->getDataSiteMap();
    //
    //     foreach ($tags as $tag) {
    //       SiteMapManager::add($tag->url, $tag->updated_at, '0.3', 'weekly');
    //     }
  }
}
