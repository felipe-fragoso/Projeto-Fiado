<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\Flash;
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

        $data = [
            'prazo' => $config->getPayLimit(),
            'credito' => $config->getMaxCredit(),
        ];
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

        $form = Flash::getForm();

        $data = [
            'id' => $config->getId(),
            'prazo' => $form['ipt-prazo'] ?? $config->getPayLimit(),
            'credito' => $form['ipt-credito'] ?? $config->getMaxCredit(),
        ];
        $data['view'] = 'loja/config/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $this->checkToken($_SERVER["BASE_URL"] . 'config');

        $form = new FormData();
        $idLoja = Auth::getId();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('payLimit', FormDataType::Int)->getValueFrom('ipt-prazo', 0);
        $form->setItem('maxCredit', FormDataType::Float)->getValueFrom('ipt-credito', 0.0);

        Flash::setForm($form->getArray());

        if (ConfigService::salvar($form->id, $idLoja, $form->payLimit, $form->maxCredit)) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'config');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'config/editar');
    }
}