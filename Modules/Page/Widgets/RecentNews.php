<?php

namespace Modules\Page\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class RecentNews extends BaseAbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = ['count' => 5];

    public function run()
    {
       
        return view('page::widgets.recent_news', [
            'config' => $this->config,
        ]);
    }
}
