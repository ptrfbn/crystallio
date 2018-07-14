<?php

namespace Core;

class View
{
    protected $css_assets = array();
    protected $js_assets = array();

    protected $output = '';

    protected $title;

    protected function __construct()
    {
        $this->addCssAsset('plugins/bootstrap/bootstrap.min');
        $this->addCssAsset('default');

        $this->addJsAsset('plugins/bootstrap/bootstrap.min');
    }

    protected function addCssAsset($path)
    {
        $this->addAsset('css', $path);
    }

    protected function addJsAsset($path)
    {
        $this->addAsset('js', $path);
    }

    protected function addAsset($type, $path)
    {
        $this->{$type . '_assets'}[] = $path;
    }

    public function render($filename)
    {
        $file = ROOT_DIR . 'template-parts/' . $filename . '.php';

        if (file_exists($file)) {
            ob_start();

            include $file;

            $html = ob_get_contents();
            ob_end_clean();

            $this->output .= $html;
        }

    }

    public function renderHtml($html)
    {
        $this->output .= $html;
    }

    public function output()
    {
        return $this->output;
    }

    public function getTitle()
    {
        return $this->title ?: 'Crystallio';
    }

    public function getCssAssets()
    {
        return $this->css_assets;
    }

    public function getJsAssets()
    {
        return $this->js_assets;
    }
}
