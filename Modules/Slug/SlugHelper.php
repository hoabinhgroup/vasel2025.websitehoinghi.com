<?php

namespace Modules\Slug;

use Illuminate\Support\Arr;
use Modules\Slug\Repositories\SlugInterface;
use Illuminate\Support\Str;

class SlugHelper
{
  /**
   * @param string | array $model
   * @return $this
   */
  public function registerModule($model, ?string $name = null): self
  {
    $supported = $this->supportedModels();

    if (!is_array($model)) {
      $supported[$model] = $name ?: $model;
    } else {
      foreach ($model as $item) {
        $supported[] = $name ?: $item;
      }
    }

    config(["slug.supported" => $supported]);

    return $this;
  }

  /**
   * @param string $model
   * @param string|null $prefix
   * @return $this
   */
  public function setPrefix(string $model, ?string $prefix): self
  {
    $prefixes = config("slug.prefixes", []);
    $prefixes[$model] = $prefix;

    config(["slug.prefixes" => $prefixes]);

    return $this;
  }

  /**
   * @return array
   */
  public function supportedModels(): array
  {
    return config("slug.supported", []);
  }

  /**
   * @return bool
   */
  public function isSupportedModel(string $model): bool
  {
    return in_array($model, $this->supportedModels());
  }

  /**
   * @param BaseModel $model
   * @return $this
   */
  public function disablePreview($model): self
  {
    if (!is_array($model)) {
      $model = [$model];
    }
    config([
      "slug.disable_preview" => array_merge(
        config("slug.disable_preview", []),
        $model
      ),
    ]);

    return $this;
  }

  /**
   * @param string $model
   * @return bool
   */
  public function canPreview(string $model): bool
  {
    return !in_array($model, config("slug.disable_preview", []));
  }

  /**
   * @param string|null $key
   * @param string $model
   * @return mixed
   */
  public function getSlug(
    ?string $key,
    ?string $prefix = null,
    ?string $model = null,
    $referenceId = null
  ) {
    $condition = [];

    if ($key !== null) {
      $condition = ["key" => $key];
    }

    if ($model !== null) {
      $condition["reference"] = $model;
    }

    if ($referenceId !== null) {
      $condition["reference_id"] = $referenceId;
    }

    if ($prefix !== null) {
      $condition["prefix"] = $prefix;
    }

    return app(SlugInterface::class)->getFirstBy($condition);
  }

  /**
   * @param string $model
   * @param string $default
   * @return string|null
   */
  public function getPrefix(string $model, string $default = ""): ?string
  {
    $permalink = setting($this->getPermalinkSettingKey($model));

    if ($permalink !== null) {
      return $permalink;
    }

    $config = Arr::get(config("packages.slug.general.prefixes", []), $model);

    if ($config !== null) {
      return (string) $config;
    }

    return $default;
  }

  /**
   * @param string $model
   * @return string
   */
  public function getPermalinkSettingKey(string $model): string
  {
    return "permalink-" . Str::slug(str_replace("\\", "_", $model));
  }

  /**
   * @return bool
   */
  public function turnOffAutomaticUrlTranslationIntoLatin(): bool
  {
    return setting("slug_turn_off_automatic_url_translation_into_latin", 0) ==
      1;
  }
}
