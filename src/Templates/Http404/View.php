<?php

namespace Templates\Http404;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct()
    {
        $this->renderHtml('Site not found!');
    }
}
