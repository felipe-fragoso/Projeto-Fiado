<?php

namespace Fiado\Core;

use Fiado\Helpers\Sanitizer;

class Controller
{
    /**
     * @param string $viewName
     * @param array $viewData
     */
    protected function load(string $viewName, array $viewData)
    {
        $data = $this->parseData($viewData);

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

    /**
     * @param string $string
     */
    private function escapeString(string $string)
    {
        return Sanitizer::escape($string);
    }

    /**
     * @param array $array
     * @return array
     */
    private function escapeArray(array $array)
    {
        $parsed = [];

        foreach ($array as $key => $mixed) {
            $parsed[$key] = $this->escapeMatch($mixed);
        }

        return $parsed;
    }

    /**
     * @param object $object
     * @return object
     */
    private function escapeObject(object $object)
    {
        $reflection = new \ReflectionObject($object);
        $props = $reflection->getProperties();

        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $oldValue = $prop->getValue($object);
            $newValue = $this->escapeMatch($oldValue, false);

            if (!$prop->isReadOnly()) {
                $prop->setValue($object, $newValue);
            }
        }

        return $object;
    }

    /**
     * @param $mixed
     * @param bool $arrayToViewHelper
     */
    private function escapeMatch($mixed, bool $arrayToViewHelper = true)
    {
        return match (true) {
            is_string($mixed) => $this->escapeString($mixed),
            is_array($mixed) => $arrayToViewHelper ? new ViewHelper($this->escapeArray($mixed)) : $this->escapeArray($mixed),
            is_object($mixed) => $this->escapeObject($mixed),
            is_int($mixed) => (int) $mixed,
            is_float($mixed) => (float) $mixed,
            is_bool($mixed) => (bool) $mixed,
            is_null($mixed) => null,
        };
    }

    /**
     * @param array $viewData
     */
    private function parseData(array $viewData)
    {
        $data = [];

        foreach ($viewData as $key => $value) {
            $data[$key] = $this->escapeMatch($value);
        }

        return new ViewHelper($data);
    }
}