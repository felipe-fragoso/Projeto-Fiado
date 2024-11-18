<?php

namespace Fiado\Models\Service;

use Fiado\Core\Auth;

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
            return false;
        }

        if (method_exists($login, 'getSenha')) {
            if (password_verify($password, $login->getSenha())) {
                Auth::setLogin([
                    'id' => $login->getId(),
                    'email' => $email,
                ], $system);

                return true;
            }
        }

        return false;
    }
}