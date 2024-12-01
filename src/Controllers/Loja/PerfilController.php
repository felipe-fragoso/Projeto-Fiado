<?php

namespace Fiado\Controllers\Loja;

use Fiado\Core\Auth;
use Fiado\Core\Controller;
use Fiado\Core\ViewHelper;
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
        $id = $_POST['ipt-id'] ?: null;
        $name = $_POST['ipt-nome'] ?? null;
        $address = $_POST['ipt-endereco'] ?? null;
        $telephone = $_POST['ipt-telefone'] ?? null;
        $established = $_POST['ipt-criada'] ?? null;
        $openHour = $_POST['ipt-abre'] ?? null;
        $closeHour = $_POST['ipt-fecha'] ?? null;
        $description = $_POST['txt-descricao'] ?? null;

        $idLoja = Auth::getId();

        if ($id) {
            $lojaPI = LojaPiService::getLojaPiById($id);
        }

        LojaPiService::salvar(
            $id,
            $idLoja,
            $address ?? $lojaPI?->getAddress() ?? '',
            $telephone ?? $lojaPI?->getTelephone() ?? '',
            $description ?? $lojaPI?->getDescription() ?? '',
            $established ?? $lojaPI?->getEstablished() ?? '',
            $openHour ?? $lojaPI?->getOpenHour() ?? '',
            $closeHour ?? $lojaPI?->getCloseHour() ?? '',
        );

        if ($name !== null) {
            $loja = LojaService::getLojaById($idLoja);
        }

        if ($loja && !LojaService::salvar($loja->getId(), $loja->getCnpj(), $name, $loja->getEmail(), $loja->getSenha())) {
            $this->redirect($_SERVER["BASE_URL"] . 'perfil/editar');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'perfil');
    }
}