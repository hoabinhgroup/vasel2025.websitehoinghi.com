<?php

namespace Modules\Registration\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function register()
    {

        Form::macro("attach", function (
            $name,
            $value = null,
            $title = "base::form.single"
        ) {
            $html = "";

            $html .= view(
                "registration::macro.attachment",
                compact("name", "value", "title")
            )->render();

            return $html;
        });
    }
}
