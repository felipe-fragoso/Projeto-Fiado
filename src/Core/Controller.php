<?php

namespace Fiado\Core;

class Controller
{
    /**
     * @param string $viewName
     * @param array $viewData
     */
    protected function load(string $viewName, array $viewData)
    {
        extract($viewData);

        $include = $_SERVER["VIEWPATH"] . $viewName . '.php';

        if (file_exists($include)) {
            include $include;
        }
    }

    /**
     * @param string $url
     */
    protected function redirect(string $url)
    {
        header("Location: {$url}");
        exit();
    }
}