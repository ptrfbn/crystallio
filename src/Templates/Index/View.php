<?php

namespace Templates\Index;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct()
    {
        parent::__construct();

        $this->render('common/header');
        $this->renderHtml('Hello world');
        $this->render('common/footer');
    }
}
