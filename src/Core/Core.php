<?php

namespace Fiado\Core;

class Core
{
    /**
     * @var mixed
     */
    private $controller;
    /**
     * @var mixed
     */
    private $method;
    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private string $system = 'Landing';

    /**
     * @param string $system
     */
    public function __construct(string $system)
    {
        $this->system = ucfirst($system);
        $this->verificaUri();
    }

    public function run()
    {
        $controller = $this->getController();
        $method = $this->getMethod();

        call_user_func_array([new $controller, $method], $this->params);
    }

    public function verificaUri()
    {
        [, $rawUri] = explode('index.php', $_SERVER['PHP_SELF']);

        if (!empty($rawUri = ltrim($rawUri, "/"))) {
            $uris = explode('/', $rawUri);

            $controller = array_shift($uris);
            $method = array_shift($uris);
            $params = $uris;

            if ($controller === 'endpoint') {
                $this->system = $controller;
                $controller = $method;
                $method = array_shift($uris);
                $params = $uris;
            }

            $this->controller = ucfirst($controller ?? $_SERVER['CONTROLLER_PADRAO']) . 'Controller';
            $this->method = $method ?? $_SERVER['METODO_PADRAO'];
            $this->params = $params;
        }
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        if (class_exists($_SERVER['CONTROLLER_NAMESPACE'] . "\\{$this->system}\\" . $this->controller)) {
            return $_SERVER['CONTROLLER_NAMESPACE'] . "\\{$this->system}\\" . $this->controller;
        }

        return $_SERVER['CONTROLLER_NAMESPACE'] . "\\{$this->system}\\" . $_SERVER['CONTROLLER_PADRAO'];
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        $controller = $this->getController();

        if ($this->method && method_exists($controller, $this->method) && is_callable([new $controller, $this->method])) {
            return $this->method;
        }

        return $_SERVER["METODO_PADRAO"];
    }
}