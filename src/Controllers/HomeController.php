<?php

namespace Fiado\Controllers;

use Fiado\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            $type = $_SESSION[$_SERVER["USER_SESSION"]]['type'];
            $dashboard = ($type == 'c') ? 'cliente' : 'loja';

            $this->redirect($_SERVER["BASE_URL"] . $dashboard);
        }
    }

    public function index()
    {
        $data['view'] = 'landing/home';

        $this->load('landing/template', $data);
    }
}