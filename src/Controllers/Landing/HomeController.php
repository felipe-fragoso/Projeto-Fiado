<?php

namespace Fiado\Controllers\Landing;

use Fiado\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data['view'] = 'landing/home';

        $this->load('landing/template', $data);
    }
}