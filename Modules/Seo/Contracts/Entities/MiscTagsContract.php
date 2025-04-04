<?php

namespace Modules\Seo\Contracts\Entities;

use Modules\Seo\Contracts\RenderableContract;

interface MiscTagsContract extends RenderableContract
{
    /**
     * Get the current URL.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set the current URL.
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url);

    /**
     * Make MiscTags instance.
     *
     * @param array $defaults
     *
     * @return self
     */
    public static function make(array $defaults = []);

    /**
     * Add a meta tag.
     *
     * @param string $name
     * @param string $content
     *
     * @return self
     */
    public function add($name, $content);

    /**
     * Add many meta tags.
     *
     * @param array $meta
     *
     * @return self
     */
    public function addMany(array $meta);

    /**
     * Remove a meta from the meta collection by key.
     *
     * @param array|string $names
     *
     * @return self
     */
    public function remove($names);

    /**
     * Reset the meta collection.
     *
     * @return self
     */
    public function reset();
}
