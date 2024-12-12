<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
use Fiado\Enums\FormDataType;
use Fiado\Helpers\FormData;
use Fiado\Models\Entity\LojaPI;
use Fiado\Models\Service\LojaPiService;
use Fiado\Models\Service\LojaService;

class PerfilController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getId();
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);

        if (!$lojaPI) {
            $lojaPI = new LojaPI(
                null,
                LojaService::getLojaById($idLoja),
                'Sem Endereco',
                'Sem Telefone',
                'Sem Descricao',
                '',
                '00:00:00',
                '00:00:00');
        }

        $data['data'] = new ViewHelper([
            'nome' => $lojaPI->getLoja()->getName(),
            'endereco' => $lojaPI->getAddress(),
            'telefone' => $lojaPI->getTelephone(),
            'criada' => $lojaPI->getEstablished(),
            'abre' => $lojaPI->getOpenHour(),
            'fecha' => $lojaPI->getCloseHour(),
            'descricao' => $lojaPI->getDescription(),
        ]);
        $data['view'] = 'loja/perfil/home';

        $this->load('loja/template', $data);
    }

    public function editar()
    {
        $idLoja = Auth::getId();
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);

        if (!$lojaPI) {
            $lojaPI = new LojaPI(null, LojaService::getLojaById($idLoja), '', '', '', '', '', '');
        }

        $data['data'] = new ViewHelper([
            'id' => $lojaPI->getId(),
            'nome' => $lojaPI->getLoja()->getName(),
            'endereco' => $lojaPI->getAddress(),
            'telefone' => $lojaPI->getTelephone(),
            'criada' => $lojaPI->getEstablished(),
            'abre' => $lojaPI->getOpenHour(),
            'fecha' => $lojaPI->getCloseHour(),
            'descricao' => $lojaPI->getDescription(),
        ]);
        $data['view'] = 'loja/perfil/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getId();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('address')->getValueFrom('ipt-endereco');
        $form->setItem('telephone', FormDataType::Telephone)->getValueFrom('ipt-telefone');
        $form->setItem('established')->getValueFrom('ipt-criada');
        $form->setItem('openHour')->getValueFrom('ipt-abre');
        $form->setItem('closeHour')->getValueFrom('ipt-fecha');
        $form->setItem('description')->getValueFrom('txt-descricao');

        if ($form->id) {
            $lojaPI = LojaPiService::getLojaPiById($form->id);
        }

        LojaPiService::salvar(
            $form->id,
            $idLoja,
            $form->address ?? $lojaPI?->getAddress() ?? '',
            $form->telephone ?? $lojaPI?->getTelephone() ?? '',
            $form->description ?? $lojaPI?->getDescription() ?? '',
            $form->established ?? $lojaPI?->getEstablished() ?? '',
            $form->openHour ?? $lojaPI?->getOpenHour() ?? '',
            $form->closeHour ?? $lojaPI?->getCloseHour() ?? '',
        );

        if ($form->name !== null) {
            $loja = LojaService::getLojaById($idLoja);
        }

        if ($loja && !LojaService::salvar($loja->getId(), $loja->getCnpj(), $form->name, $loja->getEmail(), $loja->getSenha())) {
            $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'perfil');
    }
}