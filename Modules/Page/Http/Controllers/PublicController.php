<?php

namespace Modules\Page\Http\Controllers;

use Auth;
use DataTables;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Page\Repositories\PageInterface;
use Modules\Template\Repositories\TemplateInterface;
use Modules\Languages\Repositories\LanguageInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Languages\Entities\Languages;
use Carbon\Carbon;
//use Menu;
use Modules\Page\Entities\Page;
use DB;
use Redirect;
use Theme;

class PublicController extends Controller
{
	 /**
     * @var PageInterface
     */
    protected $page;
    
    protected $lang;
    
    protected $template;
    
  

   public function __construct(
   		PageInterface $page,
   		LanguageInterface $lang,
   		TemplateInterface $template
   			)
    {
        $this->page = $page;              
        $this->lang = $lang;              
        $this->template = $template;
    }

     public function uri($slug)
    {
	    $template = "";
	   // dd($slug);
	 
	   
	 /*  $template = $this->template->find(1);
	   $elements = json_decode($template->data);
	   
	   
	  $template = $this->make_template($elements); */
	 
	  
        //$page = $this->findPageForSlug($slug);
        $page = $this->page->getPageBySlug($slug);
      
        $this->throw404IfNotFound($page);
       
        if(getFrontendLangLocale() != $page->lang_meta_code){
	        \Session::put('frontend-locale', $page->lang_meta_code);
	         return Redirect::to(apply_filters(SLUG_FILTER_BY_LANG, $slug) ?? abort(404));
			//return redirect()->route('frontend.change-language', [$page->lang_meta_code]);
			}
			
		$template = $this->getTemplateForPage($page);	
		
		$view = $template ? 'template': 'view';
		/*

        $alternate = $this->getAlternateMetaData($page);

        return view($template, compact('page', 'alternate'));
        
        */ 
        
       // $page = (object) $page;
        
        return view(\Theme::current() . "::$view", compact('page', 'template'));
    }
    
  
    
    private function make_template($elements) {
        $view = "";
        if ($elements) {

            foreach ($elements as $element) {
                $view .= "<div class='container-row clearfix row'>";

                $columns = get_array_value((array) $element, "columns");
                $column_ratio = explode("-", get_array_value((array) $element, "ratio"));

                if ($columns) {

                    foreach ($columns as $key => $value) {
                        $view .= "<div class='widget-container col-md-" . _get_column_class_value($key, $columns, $column_ratio) . "'>";
						//dd(json_decode($value[1]->config));
                        foreach ($value as $content) {
	                       
	                        $content->config = ($content->config)? $content->config : '';
	                       
                            $widget = get_array_value((array) $content, "widget");
                            if ($widget) {
	              
	                          if(view()->exists($content->screen. '::widgets.' .$content->widget )){
		                      
                                $view .= view('template::partials.frontend', ['content' => $content])->render();
                                }
                            }
                        }
                        $view .= "</div>";
                    }
                }

                $view .= "</div>";
            }
            return $view;
        }
    }
    
   

    /**
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
		
		$lang = request()->segment(1) ?? $this->lang->getDefaultLanguage()->lang_locale;
	

	   if(getFrontendLangLocale() != $lang){
	        \Session::put('frontend-locale', $lang);
	         $url = ($lang == $this->lang->getDefaultLanguage()->lang_locale)? '/' : '/'. $lang;
	         return Redirect::to($url);
			}
	   
     
        return view(\Theme::current() . '::index');
    }
    

    /**
     * Find a page for the given slug.
     * The slug can be a 'composed' slug via the Menu
     * @param string $slug
     * @return Page
     */
    private function findPageForSlug($slug)
    {
	 
       $page = $this->page->getPageBySlug($slug);
       	
          	
	   return $page;
    }
    
     /**
     * Return the template for the given page
     * or the default template if none found
     * @param $page
     * @return string
     */
    private function getTemplateForPage($page)
    {
	    if($page->template){

	   $template = $this->template->find($page->template);
	   $elements = json_decode($template->data);
	   $template = $this->make_template($elements);	  
	    }else{
	   $template =false;
	    }
        return $template;
    }
    
    private function throw404IfNotFound($page)
    {
        if (null === $page || !$page->status) {
            abort(404);
        }
    }
    
      private function getAlternateMetaData($page)
    {
        $translations = $page->getTranslationsArray();

        $alternate = [];
        foreach ($translations as $locale => $data) {
            $alternate[$locale] = $data['slug'];
        }

        return $alternate;
    }
}
