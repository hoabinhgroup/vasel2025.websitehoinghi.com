<?php

namespace Modules\Seo\Entities;

use Modules\Seo\Bases\MetaCollection as BaseMetaCollection;
use Modules\Seo\Helpers\Meta;

class MetaCollection extends BaseMetaCollection
{
    /**
     * Ignored tags, they have dedicated class.
     *
     * @var array
     */
    protected $ignored = [
        'description',
    ];

    /**
     * Add a meta to collection.
     *
     * @param string $name
     * @param string $content
     *
     * @return MetaCollection
     */
    public function add($item)
    {
        $meta = Meta::make($item['name'], $item['content']);

        if ($meta->isValid() && !$this->isIgnored($item['name'])) {
            $this->put($meta->key(), $meta);
        }

        return $this;
    }
}
