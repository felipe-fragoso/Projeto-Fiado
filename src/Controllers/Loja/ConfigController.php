<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Models\Entity\Config;
use Fiado\Models\Service\ConfigService;
use Fiado\Models\Service\LojaService;

class ConfigController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getId();
        $config = ConfigService::getConfigByLoja($idLoja);

        if (!$config) {
            $config = new Config(null, LojaService::getLojaById($idLoja), '0', '0.0');
        }

        $data['data'] = new ViewHelper([
            'prazo' => $config->getPayLimit(),
            'credito' => $config->getMaxCredit(),
        ]);
        $data['view'] = 'loja/config/home';

        $this->load('loja/template', $data);
    }

    public function editar()
    {
        $idLoja = Auth::getId();
        $config = ConfigService::getConfigByLoja($idLoja);

        if (!$config) {
            $config = new Config(null, LojaService::getLojaById($idLoja), '', '');
        }

        $data['data'] = new ViewHelper([
            'id' => $config->getId(),
            'prazo' => $config->getPayLimit(),
            'credito' => $config->getMaxCredit(),
        ]);
        $data['view'] = 'loja/config/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $id = $_POST['ipt-id'] ?: null;
        $payLimit = $_POST['ipt-prazo'] ?? null;
        $maxCredit = $_POST['ipt-credito'] ?? null;

        $idLoja = Auth::getId();

        if (ConfigService::salvar($id, $idLoja, $payLimit, $maxCredit)) {
            $this->redirect($_SERVER["BASE_URL"] . 'config');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'config/editar');
    }
}