<?php

namespace Fiado\Helpers;

class TokenManager
{
    /**
     * @return string
     */
    public static function getToken()
    {
        if (!isset($_SESSION[$_SERVER["TOKEN_SESSION"]])) {
            $_SESSION[$_SERVER["TOKEN_SESSION"]] = bin2hex(random_bytes(32));
        }

        return $_SESSION[$_SERVER["TOKEN_SESSION"]];
    }

    /**
     * @param string $data
     */
    public static function withData(string $data)
    {
        return hash_hmac('sha256', $data, self::getToken());
    }

    /**
     * @param string $data
     * @param string $token
     */
    public static function checkData(string $data, string $token)
    {
        $sessionToken = self::getToken();

        unset($_SESSION[$_SERVER["TOKEN_SESSION"]]);

        return hash_equals(hash_hmac('sha256', $data, $sessionToken), $token);
    }

    /**
     * @param string $token
     * @return bool
     */
    public static function checkToken(string $token)
    {
        $sessionToken = self::getToken();

        unset($_SESSION[$_SERVER["TOKEN_SESSION"]]);

        return $token === $sessionToken;
    }
}