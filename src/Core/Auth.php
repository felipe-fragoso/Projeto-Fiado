<?php

namespace Fiado\Core;

class Auth
{
    private static bool $isLogged;
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
    public static function login($email, $system)
    {
        $_SESSION[$_SERVER["USER_SESSION"]] = ['email' => $email, 'system' => $system];

        self::$isLogged = true;
        self::$email = $email;
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
            self::$email = $_SESSION[$_SERVER["USER_SESSION"]]['email'];
            self::$system = $_SESSION[$_SERVER["USER_SESSION"]]['system'];
        } else {
            self::$isLogged = false;
        }
    }
}