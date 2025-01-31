<?php

namespace Fiado\Models\Service;

use Fiado\Core\Auth;
use Fiado\Enums\MessageType;
use Fiado\Helpers\Flash;

class AuthService
{
    /**
     * @param $email
     * @param $password
     */
    public static function authenticate($email, $password)
    {
        if ($login = ClienteService::getClienteByEmail($email)) {
            $system = 'cliente';
        }

        if (!$login && $login = LojaService::getLojaByEmail($email)) {
            $system = 'loja';
        }

        if (!isset($system)) {
            Flash::setMessage('Email não encontrado', MessageType::Error);

            return false;
        }

        if (method_exists($login, 'getSenha')) {
            if (password_verify($password, $login->getSenha())) {
                Auth::setLogin([
                    'id' => $login->getId(),
                    'email' => $email,
                ], $system);

                Flash::clearForm();

                return true;
            }
        }

        Flash::setMessage('Email e/ou senha incorretos', MessageType::Error);

        return false;
    }
}