<?php

namespace Modules\Seo\Contracts\Entities;

use Modules\Seo\Contracts\RenderableContract;

interface MetaCollectionContract extends RenderableContract
{
    /**
     * Add a meta to collection.
     *
     * @param array $item
     *
     * @return self
     */
    public function add($item);

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
}
