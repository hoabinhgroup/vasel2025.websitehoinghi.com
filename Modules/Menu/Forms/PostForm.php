<?php

namespace Modules\Menu\Forms;

class PostForm
{
    public function buildForm()
    {
        $this
            ->add('title', 'text')
            ->add('body', 'textarea');
    }
}


