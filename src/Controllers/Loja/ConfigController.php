<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\FormData;
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
        $form = new FormData();
        $idLoja = Auth::getId();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('payLimit', FormDataType::Int)->getValueFrom('ipt-prazo');
        $form->setItem('maxCredit', FormDataType::Float)->getValueFrom('ipt-credito');

        if (ConfigService::salvar($form->id, $idLoja, $form->payLimit, $form->maxCredit)) {
            $this->redirect($_SERVER["BASE_URL"] . 'config');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'config/editar');
    }
}