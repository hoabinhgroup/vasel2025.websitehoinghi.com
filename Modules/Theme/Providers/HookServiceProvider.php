<?php

namespace Modules\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Eloquent;


class HookServiceProvider extends ServiceProvider
{
	
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	   
	   theme_option()
            ->setSection([
                'title'      => __('General'),
                'desc'       => __('General settings'),
                'id'         => 'opt-text-subsection-general',
                'subsection' => true,
                'icon'       => 'fa fa-home',
                'fields'     => [
                    [
                        'id'         => 'site_title',
                        'type'       => 'text',
                        'label'      =>  trans('Setting::setting.general.site_title'),
                        'attributes' => [
                            'name'    => 'site_title',
                            'value'   => '',
                            'options' => [
                                'class'        => 'form-control',
                               // 'placeholder'  => trans('setting::setting.general.site_title'),
                                'data-counter' => 255,
                            ],
                        ],
                    ],
                    [
                        'id'         => 'show_site_name',
                        'section_id' => 'opt-text-subsection-general',
                        'type'       => 'select',
                        'label'      => "Phân cách?",
                        'attributes' => [
                            'name'    => 'show_site_name',
                            'list'    => [
                                '0' => 'No',
                                '1' => 'Yes',
                            ],
                            'value'   => '',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'id'         => 'seo_title',
                        'type'       => 'text',
                        'label'      => trans('Setting::setting.general.seo_title'),
                        'attributes' => [
                            'name'    => 'seo_title',
                            'value'   => '',
                            'options' => [
                                'class'        => 'form-control',
                               // 'placeholder'  => trans('setting::setting.general.seo_title'),
                                'data-counter' => 120,
                            ],
                        ],
                    ],
                    [
                        'id'         => 'seo_description',
                        'type'       => 'textarea',
                        'label'      => trans('Setting::setting.general.seo_description'),
                        'attributes' => [
                            'name'    => 'seo_description',
                            'value'   => '',
                            'options' => [
                                'class' => 'form-control',
                                'rows'  => 4,
                            ],
                        ],
                    ]
                ],
            ])
            ->setSection([
                'title'      => __('Logo'),
                'desc'       => __('Logo'),
                'id'         => 'opt-text-subsection-logo',
                'subsection' => true,
                'icon'       => 'fa fa-image',
                'fields'     => [
                    [
                        'id'         => 'favicon',
                        'type'       => 'singleImage',
                        'label'      => __('Favicon'),
                        'attributes' => [
                            'name'  => 'favicon',
                            'value' => '',
                        ],
                    ],
                    [
                        'id'         => 'logo',
                        'type'       => 'singleImage',
                        'label'      => __('Logo'),
                        'attributes' => [
                            'name'  => 'logo',
                            'value' => '',
                        ],
                    ],
                    [
                        'id'         => 'top-logo',
                        'type'       => 'singleImage',
                        'label'      => 'Top Logo',
                        'attributes' => [
                            'name'  => 'top-logo',
                            'value' => '',
                        ],
                    ]
                ],
            ]);
    }
    
}
