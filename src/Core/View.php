<?php

namespace Core;

class View
{
    protected $model;
    protected $css_assets = array();
    protected $js_assets = array();

    protected $output = '';

    protected $title;

    protected function __construct($model)
    {
        $this->model = $model;

        $this->addCssAsset('plugins/bootstrap/bootstrap.min');
        $this->addCssAsset('default');

        $this->addJsAsset('plugins/jquery/jquery.min');
        $this->addJsAsset('plugins/popper/popper.min');
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

    public function renderJson($data)
    {
        header("Content-type: application/json; charset=utf-8");

        $this->output .= json_encode(
            array(
                'status' => 'success',
                'data' => $data,
            )
        );
    }

    public function renderJsonError($error_message)
    {
        header("Content-type: application/json; charset=utf-8");

        $this->output .= json_encode(
            array(
                'status' => 'error',
                'message' => $error_message,
            )
        );
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
