<?php

namespace Modules\Seo;

use Modules\Seo\Contracts\SeoHelperContract;
use Modules\Seo\Contracts\SeoMetaContract;
use Modules\Seo\Contracts\SeoOpenGraphContract;
use Modules\Seo\Contracts\SeoTwitterContract;
use Exception;
use Illuminate\Http\Request;

class SeoHelper implements SeoHelperContract
{
  /**
   * The SeoMeta instance.
   *
   * @var SeoMetaContract
   */
  private $seoMeta;

  /**
   * The SeoOpenGraph instance.
   *
   * @var SeoOpenGraphContract
   */
  private $seoOpenGraph;

  /**
   * The SeoTwitter instance.
   *
   * @var SeoTwitterContract
   */
  private $seoTwitter;

  /**
   * Make SeoHelper instance.
   *
   * @param SeoMetaContract $seoMeta
   * @param SeoOpenGraphContract $seoOpenGraph
   * @param SeoTwitterContract $seoTwitter
   */
  public function __construct(
    SeoMetaContract $seoMeta,
    SeoOpenGraphContract $seoOpenGraph,
    SeoTwitterContract $seoTwitter
  ) {
    $this->setSeoMeta($seoMeta);
    $this->setSeoOpenGraph($seoOpenGraph);
    $this->setSeoTwitter($seoTwitter);
    $this->openGraph()->addProperty("type", "website");
  }

  /**
   * Set SeoMeta instance.
   *
   * @param SeoMetaContract $seoMeta
   *
   * @return SeoHelper
   */
  public function setSeoMeta(SeoMetaContract $seoMeta)
  {
    $this->seoMeta = $seoMeta;

    return $this;
  }

  /**
   * Get SeoOpenGraph instance.
   *
   * @param SeoOpenGraphContract $seoOpenGraph
   *
   * @return SeoHelper
   */
  public function setSeoOpenGraph(SeoOpenGraphContract $seoOpenGraph)
  {
    $this->seoOpenGraph = $seoOpenGraph;

    return $this;
  }

  /**
   * Set SeoTwitter instance.
   *
   * @param SeoTwitterContract $seoTwitter
   *
   * @return SeoHelper
   */
  public function setSeoTwitter(SeoTwitterContract $seoTwitter)
  {
    $this->seoTwitter = $seoTwitter;

    return $this;
  }

  /**
   * Get SeoOpenGraph instance.
   *
   * @return SeoOpenGraphContract
   */
  public function openGraph()
  {
    return $this->seoOpenGraph;
  }

  /**
   * Set title.
   *
   * @param string $title
   * @param string|null $siteName
   * @param string|null $separator
   *
   * @return SeoHelper
   */
  public function setTitle($title, $siteName = null, $separator = null)
  {
    $this->meta()->setTitle($title, $siteName, $separator);
    $this->openGraph()->setTitle($title);
    $this->openGraph()->setSiteName($siteName);
    $this->twitter()->setTitle($title);

    return $this;
  }

  /**
   * Get SeoMeta instance.
   *
   * @return SeoMetaContract
   */
  public function meta()
  {
    return $this->seoMeta;
  }

  /**
   * Get SeoTwitter instance.
   *
   * @return SeoTwitterContract
   */
  public function twitter()
  {
    return $this->seoTwitter;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->meta()->getTitle();
  }

  public function setKeywords($keywords)
  {
    $this->meta()->setKeywords($keywords);

    return $this;
  }

  /**
   * Set description.
   *
   * @param string $description
   *
   * @return SeoHelperContract
   */
  public function setDescription($description)
  {
    $this->meta()->setDescription($description);
    $this->openGraph()->setDescription($description);
    $this->twitter()->setDescription($description);

    return $this;
  }

  /**
   * Render the tag.
   *
   * @return string
   */
  public function __toString()
  {
    return $this->render();
  }

  /**
   * Render all seo tags.
   *
   * @return string
   */
  public function render()
  {
    return implode(
      PHP_EOL,
      array_filter([
        $this->meta()->render(),
        $this->openGraph()->render(),
        $this->twitter()->render(),
      ])
    );
  }

  /**
   * @param string $screen
   * @param Request $request
   * @param BaseModel $object
   * @return bool
   */
  public function saveMetaData($request, $object)
  {
    if (in_array(get_class($object), config("seo.supported", []))) {
      try {
        if (empty($request["seo_meta"])) {
          delete_meta_data($object, "seo_meta");
          return false;
        }

        save_meta_data($object, "seo_meta", $request["seo_meta"]);
        return true;
      } catch (Exception $ex) {
        return false;
      }
    }
    return false;
  }

  public function updateMetaData($request, $object)
  {
    if (in_array(get_class($object), config("seo.supported", []))) {
      try {
        save_meta_data($object, "seo_meta", $request["seo_meta"]);
        return true;
      } catch (Exception $ex) {
        return false;
      }
    }
    return false;
  }

  /**
   * @param string $screen
   * @param BaseModel $object
   * @return bool
   */
  public function deleteMetaData($object, $action)
  {
    try {
      if (in_array(get_class($object), config("seo.supported", []))) {
        if ($action && $action == "force") {
          delete_meta_data($object, "seo_meta");
        }
      }
      return true;
    } catch (Exception $ex) {
      return false;
    }
  }

  /**
   * @param string | array $model
   * @return $this
   */
  public function registerModule($model)
  {
    if (!is_array($model)) {
      $model = [$model];
    }
    config([
      "seo.supported" => array_merge(config("seo.supported", []), $model),
    ]);

    return $this;
  }
}
