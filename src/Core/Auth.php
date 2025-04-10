<?php

namespace Fiado\Core;

class Auth
{
    private static bool $isLogged;
    private static ?int $idCliente;
    private static ?int $idLoja;
    private static ?string $email;
    private static string $system = "landing";

    /**
     * @return bool
     */
    public static function isLogged()
    {
        self::load();

        return self::$isLogged;
    }

    /**
     * @return ?string
     */
    public static function getIdCliente()
    {
        self::load();

        return self::$idCliente;
    }

    /**
     * @return ?string
     */
    public static function getIdLoja()
    {
        self::load();

        return self::$idLoja;
    }

    /**
     * @return ?string
     */
    public static function getEmail()
    {
        self::load();

        return self::$email;
    }

    /**
     * @return string
     */
    public static function getSystem()
    {
        self::load();

        return self::$system;
    }

    /**
     * @param $email
     * @param $type
     */
    public static function setLogin(array $data, $system)
    {
        $_SESSION[$_SERVER["USER_SESSION"]] = [ ...$data, 'system' => $system];

        if ($system === "cliente") {
            self::$idCliente = $data['id'];
        }

        if ($system === "loja") {
            self::$idLoja = $data['id'];
        }

        self::$isLogged = true;
        self::$email = $data['email'];
        self::$system = $system;
    }

    public static function logout()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            unset($_SESSION[$_SERVER["USER_SESSION"]]);
        }

        self::$idCliente = null;
        self::$idLoja = null;
        self::$isLogged = false;
        self::$email = null;
        self::$system = 'landing';
    }

    private static function load()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            if ($_SESSION[$_SERVER["USER_SESSION"]]['system'] === "cliente") {
                self::$idCliente = $_SESSION[$_SERVER["USER_SESSION"]]['id'];
            }

            if ($_SESSION[$_SERVER["USER_SESSION"]]['system'] === "loja") {
                self::$idLoja = $_SESSION[$_SERVER["USER_SESSION"]]['id'];
            }

            self::$isLogged = true;
            self::$email = $_SESSION[$_SERVER["USER_SESSION"]]['email'];
            self::$system = $_SESSION[$_SERVER["USER_SESSION"]]['system'];
        } else {
            self::$isLogged = false;
        }
    }
}