<?php

namespace Fiado\Helpers;

use Fiado\Enums\MessageType;

class Flash
{
    /**
     * @param string $message
     * @param MessageType $type
     */
    public static function setMessage(string $message, MessageType $type = MessageType::Success)
    {
        $msg = [
            'message' => $message,
            'type' => $type->name,
        ];

        $_SESSION[$_SERVER["MSG_SESSION"]] = $msg;
    }

    /**
     * @return mixed
     */
    public static function getMessage()
    {
        if (isset($_SESSION[$_SERVER["MSG_SESSION"]])) {
            $msg = $_SESSION[$_SERVER["MSG_SESSION"]];

            unset($_SESSION[$_SERVER["MSG_SESSION"]]);

            return $msg;
        }

        return null;
    }

    public static function clearMessage()
    {
        unset($_SESSION[$_SERVER["MSG_SESSION"]]);
    }

    /**
     * @param array $form
     */
    public static function setForm(array $form)
    {
        $_SESSION[$_SERVER["FORM_SESSION"]] = $form;
    }

    /**
     * @return mixed
     */
    public static function getForm()
    {
        if (isset($_SESSION[$_SERVER["FORM_SESSION"]])) {
            $form = $_SESSION[$_SERVER["FORM_SESSION"]];

            unset($_SESSION[$_SERVER["FORM_SESSION"]]);

            return $form;
        }

        return null;
    }

    public static function clearForm()
    {
        unset($_SESSION[$_SERVER["FORM_SESSION"]]);
    }

    /**
     * @param array $errors
     */
    public static function setError(array $errors)
    {
        if (isset($_SESSION[$_SERVER["ERROR_SESSION"]])) {
            $_SESSION[$_SERVER["ERROR_SESSION"]] += $errors;
        } else {
            $_SESSION[$_SERVER["ERROR_SESSION"]] = $errors;
        }
    }

    /**
     * @return mixed
     */
    public static function getError()
    {
        if (isset($_SESSION[$_SERVER["ERROR_SESSION"]])) {
            $errors = $_SESSION[$_SERVER["ERROR_SESSION"]];

            unset($_SESSION[$_SERVER["ERROR_SESSION"]]);

            return $errors;
        }

        return null;
    }

    public static function clearError()
    {
        unset($_SESSION[$_SERVER["ERROR_SESSION"]]);
    }
}