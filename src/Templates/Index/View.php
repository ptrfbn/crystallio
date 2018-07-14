<?php

namespace Templates\Index;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->addJsAsset('pages/index');

        $this->render('common/header');
        $this->render('index');
        $this->render('common/footer');
    }
}
