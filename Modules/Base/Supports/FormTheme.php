<?php

namespace Modules\Base\Supports;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use URL;

class FormTheme
{
  	public function render($path, array $args, $template_default = 'base::partial.form')
  	{
	  	$form = '';
	  	$view = '';
	  	$form = view($path, $args)->render();
	  	$view.= view($template_default, array_merge(['view' => $form], $args))->render();

	  	return $view;
  	}

   
}
