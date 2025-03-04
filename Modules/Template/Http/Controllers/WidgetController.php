<?php

namespace Modules\Template\Http\Controllers;

use Response;
use Auth;
use Illuminate\Http\Request;
use Modules\Acl\Entities\Users;
//use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Repositories\TemplateInterface;
use Carbon\Carbon;

class WidgetController extends Controller
{
	
	 /**
     * @var TemplateInterface
     */
    protected $template;
    
  

   public function __construct(
   		TemplateInterface $template
   			)
    {
        $this->template = $template;
    }
	
    /**
     * Display a listing of the resource.
     * @return Response
     */
   public function config(Request $request)
    {
	    $data = $request->all();
	 // return $data;
	  
		if($request->config != null){
			//return view('registration::widgets.'.$request->widget.'Config', ['data' => $data]);
			$data['config'] = json_decode($request->config);
	
			if(isset($data['config']) && count($data['config']) > 0){
			foreach($data['config'] as $value):
			$data[$value->name] = $value->value;
			endforeach;
			}
			
		}
		
		if(str_contains($request->widget,'Form')){
		 	
		 	$widgetForm = $request->widget;
		
	 	}else{
		 	$widgetForm =  $request->widget .'Form';
	 	}
	 	
	 	$modal = form(app("Modules\Base\Forms\FormBuilder")->create("Modules\\". ucfirst($request->screen) ."\\Forms\\Widgets\\".ucfirst($widgetForm) ."", ['model' => $data]));
	
	
		//$modal = view( $request->screen . '::widgets.'.$request->widget.'Config', ['data' => $data])->render();
		$modal.= view('template::widget.config', ['data' => $data])->render();
	    //registration::widgets.registrationForm
        return $modal;
    }
       
   
}
