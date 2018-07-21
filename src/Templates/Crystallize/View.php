<?php

namespace Templates\Crystallize;

use Core\View as BaseView;

class View extends BaseView
{
    public function __construct($model)
    {
        parent::__construct($model);

        if (!$model->hasError()) {
            $this->renderJson($model->getData());
        } else {
            $this->renderJsonError($model->getErrors());
        }

    }
}
