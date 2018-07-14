<?php

namespace Templates\Http404;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct($model)
    {
        parent::__construct($model);

        $this->render('common/header');
        $this->render('404');
        $this->render('common/footer');
    }
}
