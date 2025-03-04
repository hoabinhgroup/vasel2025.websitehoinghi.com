<?php

namespace Modules\Slug\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Modules\Slug\Repositories\SlugInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Slug;
use Assets;
use Language;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        add_filter(BASE_FILTER_SLUG_AREA, [$this, "addSlugBox"], 17);

        add_filter(
            BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM,
            [$this, "addSlugBeforeGetListItem"],
            50,
            4
        );
        add_filter(
            BASE_FILTER_BEFORE_GET_ADMIN_SINGLE,
            [$this, "addSlugBeforeGetListItem"],
            50,
            4
        );
        add_filter(
            BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM,
            [$this, "checkItemSlugBeforeShow"],
            50,
            3
        );
    }

    /**
     * @param BaseModel $object
     * @param null|string  $prefix
     * @return null|string
     * @throws Throwable
     */
    public function addSlugBox($object = null)
    {
  
        if ($object && Slug::isSupportedModel(get_class($object))) {
            Assets::addJs(domain() . "/vendor/core/modules/slug/js/slug.js");
            Assets::addCss(domain() . "/vendor/core/modules/slug/css/slug.css");

            $prefix = Slug::getPrefix(get_class($object));
                

            return view(
                "slug::partials.slug",
                compact("object", "prefix")
            )->render();
        }

        return null;
    }

    public function addSlugBeforeGetListItem($data, $model)
    {
        return $this->getDataByCurrentSlug($data, $model);
    }

    public function checkItemSlugBeforeShow($data, $model)
    {
        return $this->getDataByCurrentSlug($data, $model);
    }

    public function getDataByCurrentSlug($data, $model)
    {

        if (
            $data &&
            in_array(get_class($model), config("slug.supported", []))
        ) {

            $table = $model->getTable();

            $select = [$table . ".*", "slugs.key as key"];

            if (is_plugin_active("Languages")) {
                if (
                    in_array(
                        get_class($model),
                        Language::screenUsingMultiLanguage()
                    )
                ) {
                    $select[] = "language_meta.*";
                }
            }

            // dd($data);
            return $data
                ->leftJoin("slugs", function (JoinClause $join) use ($table) {
                    $join->on("slugs.reference_id", "=", $table . ".id");
                })
                ->select($select)
                ->where("slugs.reference_type", "=", get_class($model));
        }

        return $data;
    }

    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
