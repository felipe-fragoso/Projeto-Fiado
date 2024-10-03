<?php

namespace Fiado\Controllers;

use Fiado\Core\Controller;
use Fiado\Models\Service\ClienteService;
use Fiado\Models\Service\LojaService;

class AuthController extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            $type = $_SESSION[$_SERVER["USER_SESSION"]]['type'];
            $dashboard = ($type == 'c') ? 'cliente' : 'loja';

            $this->redirect($_SERVER["BASE_URL"] . $dashboard);
        }
    }

    public function login()
    {
        $data['view'] = 'signin';

        $this->load('signin', $data);
    }

    public function entrar()
    {
        $email = $_POST['ipt-email'] ?? null;
        $password = $_POST['ipt-senha'] ?? null;

        if (empty($email) || empty($password)) {
            $this->redirect($_SERVER["BASE_URL"] . 'auth/login');
        }

        if (ClienteService::getLogin($email, $password)) {
            $_SESSION[$_SERVER["USER_SESSION"]] = ['email' => $email, 'type' => 'c'];

            $this->redirect($_SERVER["BASE_URL"] . 'cliente');
        }

        if (LojaService::getLogin($email, $password)) {
            $_SESSION[$_SERVER["USER_SESSION"]] = ['email' => $email, 'type' => 'e'];

            $this->redirect($_SERVER["BASE_URL"] . 'loja');
        }

        $this->redirect($_SERVER["BASE_URL"] . 'auth/login');
    }

    public function cadastro()
    {
        $data['tipo'] = $_GET['tipo'] ?? 'c';
        $data['view'] = 'signup';

        $this->load('signup', $data);
    }

    /**
     * @return mixed
     */
    public function salvar()
    {
        $cpf = $_POST['ipt-cpf'] ?? null;
        $cnpj = $_POST['ipt-cnpj'] ?? null;
        $email = $_POST['ipt-email'] ?? null;
        $name = $_POST['ipt-nome'] ?? null;
        $password = $_POST['ipt-senha'] ?? null;
        $conPassword = $_POST['ipt-con-senha'] ?? null;
        $tipo = $_POST['tipo'] ?? null;

        $urlCadastro = $_SERVER["BASE_URL"] . "auth/cadastro?tipo={$tipo}";
        $urlDashboard = $_SERVER["BASE_URL"] . (($tipo == 'e') ? 'loja' : 'cliente');

        if (($password !== $conPassword) || (empty($email) || empty($password) || empty($password)) || (empty($cpf) && empty($cnpj))) {
            return $this->redirect($urlCadastro);
        }

        if ($cpf) {
            if (ClienteService::salvar(null, $cpf, $name, $email, $password)) {
                return $this->redirect($urlDashboard);
            }

            return $this->redirect($urlCadastro);
        }

        if ($cnpj) {
            if (LojaService::salvar(null, $cnpj, $name, $email, $password)) {
                return $this->redirect($urlDashboard);
            }

            return $this->redirect($urlCadastro);
        }
    }
}