<?php

namespace Fiado\Core;

class Auth
{
    private static bool $isLogged;
    private static ?int $id;
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
    public static function getEmail()
    {
        self::load();

        return self::$email;
    }
    
    /**
     * @return ?string
     */
    public static function getID()
    {
        self::load();

        return self::$id;
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
        $_SESSION[$_SERVER["USER_SESSION"]] = [...$data, 'system' => $system];

        self::$isLogged = true;
        self::$id = $data['id'];
        self::$email = $data['email'];
        self::$system = $system;
    }

    public static function logout()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            unset($_SESSION[$_SERVER["USER_SESSION"]]);
        }

        self::$isLogged = false;
        self::$email = null;
        self::$system = 'landing';
    }

    private static function load()
    {
        if (isset($_SESSION[$_SERVER["USER_SESSION"]])) {
            self::$isLogged = true;
            self::$id = $_SESSION[$_SERVER["USER_SESSION"]]['id'];
            self::$email = $_SESSION[$_SERVER["USER_SESSION"]]['email'];
            self::$system = $_SESSION[$_SERVER["USER_SESSION"]]['system'];
        } else {
            self::$isLogged = false;
        }
    }
}