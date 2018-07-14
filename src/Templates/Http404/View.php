<?php

namespace Templates\Http404;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->renderHtml('Site not found!');
    }
}
