<?php

namespace Modules\Slug\Services;

use Modules\Slug\Repositories\SlugInterface;
use Illuminate\Support\Str;
use Slug;

class SlugService
{
    /**
     * @var SlugInterface
     */
    protected $slug;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param string $name
     * @param int $slugId
     * @return int|string
     */
    public function create($name, $slugId = 0, $model = null)
    {
        $slug = Str::slug(
            $name,
            "-",
            !Slug::turnOffAutomaticUrlTranslationIntoLatin() ? "en" : false
        );

        $index = 1;
        $baseSlug = $slug;

        $prefix = null;
        if (!empty($model)) {
            $prefix = Slug::getPrefix($model);
        }

        while ($this->checkIfExistedSlug($slug, $slugId, $prefix)) {
            $slug = apply_filters(
                FILTER_SLUG_EXISTED_STRING,
                $baseSlug . "-" . $index++,
                $baseSlug,
                $index,
                $model
            );
        }

        if (empty($slug)) {
            $slug = time();
        }

        return apply_filters(FILTER_SLUG_STRING, $slug, $model);
    }

    /**
     * @param string $slug
     * @param string $slugId
     * @param string $prefix
     * @return bool
     */
    protected function checkIfExistedSlug($slug, $slugId, $prefix)
    {
        $model = app()->make($this->slug->getModel());
        return $model
            ->where([
                "key" => $slug,
                "prefix" => $prefix,
            ])
            ->where("id", "!=", (int) $slugId)
            ->count() > 0;
    }
}
