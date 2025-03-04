<?php

namespace Modules\Base\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class TagField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
       $domain = 'http://'.request()->getHost();
         Assets::add([
		   domain() . '/vendor/tagify/tagify.css',
		   domain() . '/vendor/tagify/tagify.min.js',
		  // 'https://cdn.jsdelivr.net/npm/@yaireo/tagify@3.1.0/dist/tagify.min.js',
		  //	 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
		   domain() .  '/js/tags.js',
		   domain() .  '/vendor/tagify/jQuery.tagify.min.js'
	    ]);


        return 'base::forms.fields.tags';
    }
}
