<?php

namespace Modules\Template;
use Modules\Template\Repositories\TemplateInterface;
use Modules\Base\Traits\CommonFunctions;

class Template
{
	use CommonFunctions;
	
	protected $template;
	
	public function __construct(TemplateInterface $template)
    {
        $this->repository = $template;

    }
    
    
    public function form($path, array $args, $template_default = 'base::partial.form')
  	{
	  	$form = '';
	  	$view = '';
	  	$form = view($path, $args)->render();
	  	$view.= view($template_default, array_merge(['view' => $form], $args))->render();

	  	return $view;
  	}
  	
  	 public function table($path, array $args = [], $template_default = 'base::partial.table')
  	{
	  	$form = '';
	  	$view = '';
	  	$form = view($path, $args)->render();
	  	$view.= view($template_default, array_merge(['view' => $form], $args))->render();

	  	return $view;
  	}

}
