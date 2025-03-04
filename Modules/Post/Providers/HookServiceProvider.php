<?php

namespace Modules\Post\Providers;

use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Modules\Post\Entities\Categories;
use Modules\Post\Repositories\CategoriesInterface;
use Modules\Post\Repositories\PostInterface;
use Modules\Slug\Repositories\SlugInterface;
use Modules\Template\Repositories\TemplateInterface;
use Modules\Menu\Repositories\MenuNodeInterface;
use TorMorten\Eventy\Facades\Events as Eventy;
use Lang;
use Eloquent;
use Breadcrumb;
use Modules\Seo\SeoOpenGraph;
use SeoHelper;
use KubAT\PhpSimple\HtmlDomParser;
use Menu;

class HookServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function boot()
  {
    add_action(MENU_SIDEBAR, [$this, "registerMenuOptions"], 1);
    add_filter(
      BASE_FILTER_PUBLIC_SINGLE_DATA,
      [$this, "handleSingleView"],
      2,
      1
    );


    // Eventy::addFilter(MENU_SIDEBAR_IMPORT, [$this, 'menuImport'], 21, 1);
  }

  /**
   * Register sidebar options in menu
   * @throws \Throwable
   */
  public function registerMenuOptions($model)
  {
    $categories = Menu::generateSelect([
      "model" => $this->app->make(CategoriesInterface::class)->getModel(),
      "type" => Categories::class,
      "theme" => false,
      "options" => [
        "class" => "list-item",
      ],
    ]);

    echo view("post::partials.menu-options", compact("categories"));
  }

  public function handleSingleView($slug)
  {
    if (is_object($slug)) {

      $data = [];

      $condition = [
        "id" => $slug->reference_id,
        "status" => BaseStatusEnum::PUBLISHED,
      ];

      switch ($slug->reference_type) {
        case app(PostInterface::class)->getModel():
          $post = app(PostInterface::class)->findByWhere($condition);


          if (!empty($post)) {
            $view = "post";

            $category_id = $post->categories()->first()->id;
            $category = app(CategoriesInterface::class)->getFirstBy(
              ["id" => $category_id],
              ["*"]
            );

            $slug_category = app(SlugInterface::class)->getFirstBy([
              "reference_id" => $category_id,
              "reference_type" => app(CategoriesInterface::class)->getModel(),
            ]);

            $category_slug = $slug_category->key;

            //add seo
            Breadcrumb::add("Trang chủ", url("/"))
              ->add(
                $post->categories()->first()->name,
                $category_slug . ".html"
              )
              ->add($post->name, $post->slug . ".html");
            $tags = [];
            if (!$post->tags->isEmpty()) {
              foreach ($post->tags as $tag):
                $tags[] = $tag->name;
              endforeach;
            }
            $tags = implode(", ", $tags);

            $metabox = app(
              \Modules\Base\Repositories\MetaBoxInterface::class
            )->getFirstBy([
              "reference_id" => $post->id,
              "reference_type" => "Modules\Post\Entities\Post",
            ]);

            if ($metabox) {
              $meta_value = json_decode($metabox->meta_value)[0];

              $seo_title = $meta_value->seo_title ?? $post->name;
              $seo_keywords = $meta_value->seo_keywords ?? $tags;
              $seo_description =
                $meta_value->seo_description ??
                \Str::limit($post->description, 180, ".");

              \SeoHelper::setTitle($seo_title)
                ->setKeywords($seo_keywords)
                ->setDescription($seo_description);

              $meta = new SeoOpenGraph();
              if ($post->image) {
                $meta->setImage(domain() . $post->image);
              }
              $meta->setDescription($seo_description);
              $meta->setUrl($post->url);
              $meta->setTitle($seo_title);
              $meta->setType("article");

              SeoHelper::setSeoOpenGraph($meta);
            }
            $type = "post";

            //do action
            do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, POST_MODULE_NAME, $post);
            //binding
            $data = [
              "view" => "post",
              "default_view" => "post::" . $view,
              "type" => $view,
              "data" => compact("post"),
              "slug" => $post->slug,
            ];

            return $data;
          }

          break;
        case app(CategoriesInterface::class)->getModel():
          $category = app(CategoriesInterface::class)->getFirstBy(
            ["id" => $slug->reference_id],
            ["*"]
          );

          $slug_category = app(SlugInterface::class)->getFirstBy([
            "reference_id" => $slug->reference_id,
            "reference_type" => app(CategoriesInterface::class)->getModel(),
          ]);

          $category["slug"] = $slug_category->key;
          //$slug_category->key;

          // các category lien quan
          $allRelatedCategoryIds = array_unique(
            array_merge(
              app(CategoriesInterface::class)->getAllRelatedChildrenIds(
                $category
              ),
              [$category->id]
            )
          );

          //seo
          $metabox = app(
            \Modules\Base\Repositories\MetaBoxInterface::class
          )->getFirstBy([
            "reference_id" => $category->id,
            "reference_type" => "Modules\Post\Entities\Categories",
          ]);
          if ($metabox) {
            $meta_value = json_decode($metabox->meta_value)[0];

            $seo_title = $meta_value->seo_title ?? $category->name;
            $seo_keywords = $meta_value->seo_keywords ?? "";
            $seo_description =
              $meta_value->seo_description ??
              \Str::limit($category->description, 180, ".");

            \SeoHelper::setTitle($seo_title)
              ->setKeywords($seo_keywords)
              ->setDescription($seo_description);

            Breadcrumb::add("Trang chủ", url("/"))
              // ->add('aaa')
              ->add($category->name, $category->slug . ".html");

            $meta = new SeoOpenGraph();
            if ($category->image) {
              $meta->setImage(domain() . $category->image);
            }
            $meta->setDescription($seo_description);
            $meta->setUrl($category->url);
            $meta->setTitle($seo_title);
            $meta->setType("categories");

            SeoHelper::setSeoOpenGraph($meta);
          }
          $view = "categories";

          // post theo category
          $posts = app(PostInterface::class)->getByCategory(
            $allRelatedCategoryIds,
            12
          );

          // breadcrum

          return [
            "view" => "category",
            "default_view" => "post::themes.category",
            "type" => $view,
            "data" => compact("category", "posts"),
          ];
          break;
      }
    }
    return $slug;
  }
}
