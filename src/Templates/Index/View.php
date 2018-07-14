<?php

namespace Templates\Index;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->render('common/header');
        $this->renderHtml('Hello world');
        $this->render('common/footer');
    }
}
