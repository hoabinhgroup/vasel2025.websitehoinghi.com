<?php

namespace Modules\Seo\Contracts\Entities;

use Modules\Seo\Contracts\RenderableContract;

interface DescriptionContract extends RenderableContract
{
    /**
     * Get raw description content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Get description content.
     *
     * @return string
     */
    public function get();

    /**
     * Set description content.
     *
     * @param string $content
     *
     * @return self
     */
    public function set($content);

    /**
     * Get description max length.
     *
     * @return int
     */
    public function getMax();

    /**
     * Set description max length.
     *
     * @param int $max
     *
     * @return self
     */
    public function setMax($max);

    /**
     * Make a description instance.
     *
     * @param string $content
     * @param int $max
     *
     * @return self
     */
    public static function make($content, $max = 155);
}
