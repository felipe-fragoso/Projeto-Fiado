<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Enums\FormDataType;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;
use Fiado\Helpers\FormData;
use Fiado\Models\Entity\LojaPI;
use Fiado\Models\Service\LojaPiService;
use Fiado\Models\Service\LojaService;

class PerfilController extends Controller
{
    public function index()
    {
        $idLoja = Auth::getIdLoja();
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);

        if (!$lojaPI) {
            $lojaPI = new LojaPI(
                null,
                LojaService::getLojaById($idLoja),
                'Endereco vazio',
                'Telefone vazio',
                'Descrição vazia',
                '0000-00-00 00:00:00',
                '00:00:00',
                '00:00:00');
        }

        $data = [
            'nome' => $lojaPI->getLoja()->getName(),
            'cnpj' => $lojaPI->getLoja()->getCnpj(),
            'email' => $lojaPI->getLoja()->getEmail(),
            'endereco' => $lojaPI->getAddress() ?: 'Endereço vazio',
            'telefone' => $lojaPI->getTelephone() ?: 'Telefone vazio',
            'criada' => $lojaPI->getEstablished(),
            'abre' => $lojaPI->getOpenHour(),
            'fecha' => $lojaPI->getCloseHour(),
            'descricao' => $lojaPI->getDescription() ?: 'Descrição vazia',
        ];
        $data['view'] = 'loja/perfil/home';

        $this->load('loja/template', $data);
    }

    public function editar()
    {
        $idLoja = Auth::getIdLoja();
        $lojaPI = LojaPiService::getLojaPiByLoja($idLoja);

        if (!$lojaPI) {
            $lojaPI = new LojaPI(null, LojaService::getLojaById($idLoja), '', '', '', '', '', '');
        }

        $form = Flash::getForm();

        $data = [
            'id' => $lojaPI->getId(),
            'nome' => $form['ipt-nome'] ?? $lojaPI->getLoja()->getName(),
            'endereco' => $form['ipt-endereco'] ?? $lojaPI->getAddress(),
            'telefone' => $form['ipt-telefone'] ?? $lojaPI->getTelephone(),
            'criada' => $form['ipt-criada'] ?? $lojaPI->getEstablished(),
            'abre' => $form['ipt-abre'] ?? $lojaPI->getOpenHour(),
            'fecha' => $form['ipt-fecha'] ?? $lojaPI->getCloseHour(),
            'descricao' => $form['txt-descricao'] ?? $lojaPI->getDescription(),
            'tokenData' => $lojaPI->getId(),
        ];
        $data['view'] = 'loja/perfil/edit';

        $this->load('loja/template', $data);
    }

    public function salvar()
    {
        $form = new FormData();
        $idLoja = Auth::getIdLoja();

        $form->setItem('id', FormDataType::Int)->getValueFrom('ipt-id');
        $form->setItem('name')->getValueFrom('ipt-nome');
        $form->setItem('address')->getValueFrom('ipt-endereco');
        $form->setItem('telephone', FormDataType::Telephone)->getValueFrom('ipt-telefone');
        $form->setItem('established', FormDataType::Datetime)->getValueFrom('ipt-criada');
        $form->setItem('openHour', FormDataType::Time)->getValueFrom('ipt-abre');
        $form->setItem('closeHour', FormDataType::Time)->getValueFrom('ipt-fecha');
        $form->setItem('description')->getValueFrom('txt-descricao');

        $this->checkToken($_SERVER["BASE_URL"] . 'perfil', $form->id);

        Flash::setForm($form->getArray());

        if ($form->id) {
            $lojaPI = LojaPiService::getLojaPiById($form->id);
        }

        $successLojaPI = LojaPiService::salvar(
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

        if (isset($loja)) {
            $successLoja = LojaService::salvar(
                $loja->getId(),
                $loja->getCnpj(),
                $form->name,
                $loja->getEmail(),
                $loja->getSenha(),
                $loja->getSenha(),
                $loja->getDate(),
            );
        }

        if (($successLojaPI === 0 && !isset($successLoja)) || (isset($successLoja) && $successLoja === 0 && $successLojaPI === 0)) {
            Flash::setMessage('Nenhum registro alterado', MessageType::Warning);

            $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
        }

        if ($successLojaPI !== false && $successLoja !== false) {
            Flash::clearForm();
            Flash::setMessage('Operação realizada com sucesso');

            $this->redirect($_SERVER["BASE_URL"] . 'perfil');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
    }
}