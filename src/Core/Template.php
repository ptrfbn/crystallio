<?php

namespace Core;

class Template
{
    public static function load($template)
    {
        $model_class = 'Templates\\' . $template . '\\Model';
        $controller_class = 'Templates\\' . $template . '\\Controller';
        $view_class = 'Templates\\' . $template . '\\View';

        $model = new $model_class();
        $controller = new $controller_class();
        $view = new $view_class($model);

        echo $view->output();
    }
}
