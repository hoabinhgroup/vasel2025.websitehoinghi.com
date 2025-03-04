<?php

namespace Modules\Theme\Http\Controllers;

//use Botble\Theme\Events\RenderingSingleEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Page\Repositories\PageInterface;
use Modules\Slug\Repositories\SlugInterface;
use Modules\Template\Repositories\TemplateInterface;
//use Botble\Theme\Events\RenderingHomePageEvent;
use Modules\Theme\Events\RenderingSiteMapEvent;
//use Modules\Languages\Repositories\LanguageInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Response;
use SiteMapManager;
use Theme;
use Redirect;

class PublicController extends Controller
{
  /**
   * @var SlugInterface
   */
  protected $slug;

  protected $lang;

  protected $template;

  /**
   * @var SettingStore
   */
  protected $settingStore;

  /**
   * PublicController constructor.
   * @param SlugInterface $slugRepository
   * @param SettingStore $settingStore
   */
  public function __construct(SlugInterface $slug, TemplateInterface $template)
  {
    $this->slug = $slug;
    $this->template = $template;
  }

  /**
   * @param BaseHttpResponse $response
   * @return BaseHttpResponse|\Illuminate\Http\Response|Response
   * @throws FileNotFoundException
   */
  public function getIndex(BaseHttpResponse $response)
  {
    // event(RenderingHomePageEvent::class);
    $lang = request()->segment(1) ?? getBaseDefaultLanguage();

    if (is_plugin_active("Languages") && getFrontendLangLocale() != $lang) {
      \Session::put("frontend-locale", $lang);
      $url =
        $lang == $this->lang->getDefaultLanguage()->lang_locale
          ? "/"
          : "/" . $lang;
      return Redirect::to($url);
    }


    return view(Theme::current() . "::index");
    // return Theme::render("index");
  }

  /**
   * @param string $key
   * @param BaseHttpResponse $response
   * @return BaseHttpResponse|Response
   * @throws FileNotFoundException
   */
  public function getView(BaseHttpResponse $response, $key = null)
  {
    return parent::getView($response, $key);
  }

  /**
   * @return string
   */
  public function getSiteMap()
  {
    event(RenderingSiteMapEvent::class);

    // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    return SiteMapManager::render("xml");
  }
}
