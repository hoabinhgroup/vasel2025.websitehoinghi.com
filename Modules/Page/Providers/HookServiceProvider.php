<?php

namespace Modules\Page\Providers;

use Modules\Base\Enums\BaseStatusEnum;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageInterface;
use Modules\Template\Repositories\TemplateInterface;
use Modules\Menu\Repositories\MenuNodeInterface;
use Eloquent;
use KubAT\PhpSimple\HtmlDomParser;
use Modules\Seo\SeoOpenGraph;
use SeoHelper;
use Menu;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        // add_action(BASE_ACTION_META_BOXES, [$this, "addMetaBox"], 12, 2);
        // Eventy::addAction(BASE_ACTION_META_BOXES, [$this, 'addMetaBox2'], 12, 2);
        //add_action(BASE_ACTION_META_BOXES, [$this, 'addMetaBox'], 12, 2);
        add_action(MENU_SIDEBAR, [$this, "registerMenuOptions"], 1);
        add_filter(
            BASE_FILTER_PUBLIC_SINGLE_DATA,
            [$this, "handleSingleView"],
            1,
            1
        );
        add_action(WIDGET_LIST, [$this, "registerWidgetList"], 2);
    }

    public function addMetaBox($view, $data)
    {
        //         $doc = HtmlDomParser::str_get_html($view);
        //
        //         $descBox = $doc->find("form > .row > .col-md-9", 0);
        //
        //         $appended = $doc->createElement("div", view("base::test"));
        //
        //         $descBox->appendChild($appended);
        //
        //         echo $doc;
        return true;
    }

    /**
     * Register sidebar options in menu
     * @throws \Throwable
     */
    public function registerMenuOptions($model)
    {
        /*
	    $categories = DB::table('pages as p')
	 		->join('language_meta as l', 'l.lang_meta_content_id', '=', 'p.id')
	 		->where('l.lang_meta_code',$model->lang_meta_code)
	 		->where('l.lang_meta_reference', $this->app->make(PageInterface::class)->getModel())->get()->toArray();
	 	$params = [
		 	'table' => $this->app->make(PageInterface::class)->getTable(),
	 		'namespace' => 'Page_Page',
	 		'lang' => $model->lang_meta_code,
	 		'label' => "Page"
	 		];

	 	$table = $params['table'];

	 	echo view('menu::cmspanel.partials.menu-options', compact('table','categories', 'params'));
*/

        $pages = Menu::generateSelect([
            "model" => $this->app->make(PageInterface::class)->getModel(),
            "type" => Page::class,
            "theme" => false,
            "options" => [
                "class" => "list-item",
            ],
        ]);

        echo view("page::partials.menu-options", compact("pages"));
    }

    public function registerWidgetList($template_id)
    {
        return displayWidgetListByModule(PAGE_SCREEN, $template_id);
    }

    public function handleSingleView($slug)
    {
        if (is_object($slug)) {
            $data = [];
            $condition = [
                "pages.id" => $slug->reference_id,
                "status" => BaseStatusEnum::PUBLISHED,
            ];

            if ($slug->reference_type === app(PageInterface::class)->getModel()) {
                $page = app(PageInterface::class)->findByWhere($condition);
                if (!empty($page)) {

                    //add seo
                    SeoHelper::setTitle($page->name)->setDescription(
                        $page->description
                    );

                    $meta = new SeoOpenGraph();
                    if ($page->image) {
                        $meta->setImage(domain() . $page->image);
                    }
                    $meta->setDescription($page->description);
                    $meta->setUrl($page->url);
                    $meta->setTitle($page->name);
                    $meta->setType("article");

                    SeoHelper::setSeoOpenGraph($meta);

                    $template = [];
                    // add template if has
                    $template = $this->getTemplateForPage($page);

                    $view = $template ? "template" : "view";

                    //do action
                    //do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PAGE_MODULE_SCREEN_NAME, $page);
                    //binding
                    $data = [
                        "view" => "page",
                        "default_view" => "page::" . $view,
                        "type" => $view,
                        "data" => compact("page"),
                        "template" => $template,
                        "slug" => $page->key,
                    ];

                    return $data;
                }
            }
        }
        return $slug;
    }

    public function getTemplateForPage($page)
    {
        if ($page->template) {
            $template = app(TemplateInterface::class)->find($page->template);
            $elements = json_decode($template->data);
            $template = make_template($elements);
        } else {
            $template = false;
        }
        return $template;
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
