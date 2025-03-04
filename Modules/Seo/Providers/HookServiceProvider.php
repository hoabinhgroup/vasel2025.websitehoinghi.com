<?php

namespace Modules\Seo\Providers;

use Assets;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use SeoHelper;
use MetaBox;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_action(BASE_ACTION_META_BOXES, [$this, "addMetaBox"], 12, 2);
    }

    /**
     * @param string $screen
     * @param BaseModel $data
     */
    public function addMetaBox($priority, $data)
    {
        if (
            !empty($data) &&
            in_array(get_class($data), config("seo.supported", []))
        ) {
            //  $domain = 'http://'.request()->getHost();
            Assets::add([
                domain() . "/vendor/core/seo-helper/css/seo-helper.css",
                domain() . "/vendor/core/seo-helper/js/seo-helper.js",
            ]);
            MetaBox::addMetaBox(
                "seo_wrap",
                __("base::metabox.meta_box_header"),
                [$this, "seoMetaBox"],
                get_class($data),
                "advanced",
                "low"
            );
        }
    }

    /**
     * @return Factory|View
     */
    public function seoMetaBox()
    {
        $meta = [
            "seo_title" => null,
            "seo_description" => null,
        ];

        $args = func_get_args();
        if (!empty($args[0]) && $args[0]->id) {
            $metadata = json_decode(
                MetaBox::getMetaData($args[0], "seo_meta", true)
            );
            $metadata = (array) $metadata[0];
        }

        if (!empty($metadata) && is_array($metadata)) {
            $meta = array_merge($meta, $metadata);
        }

        $object = $args[0];

        return view("seo::meta-box", compact("meta", "object"));
    }

    /**
     * @param string $screen
     * @param BaseModel $object
     */
    public function setSeoMeta($screen, $object)
    {
        $meta = MetaBox::getMetaData($object, "seo_meta", true);
        if (!empty($meta)) {
            if (!empty($meta["seo_title"])) {
                SeoHelper::setTitle($meta["seo_title"]);
            }

            if (!empty($meta["seo_description"])) {
                SeoHelper::setDescription($meta["seo_description"]);
            }
        }
    }
}
