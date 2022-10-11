<?php

namespace app\core;

class View
{
    public string $title = '';

    public function renderView($view,$params = [])
    {
        $contentView = $this->renderOnlyView($view,$params);
        $layoutContent = $this->layoutContent();
        return  str_replace("{{content}}",$contentView,$layoutContent);
    }

    protected  function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOTDIR."/views/layout/$layout.php";
        return  ob_get_clean();
    }

    protected function renderOnlyView($view,$params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOTDIR."/views/$view.php";
        return  ob_get_clean();
    }
}