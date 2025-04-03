<?php
namespace Fiado\Helpers;

class Sanitizer
{
    /**
     * @param ?string $data
     */
    public static function sanitizeInt(?string $data): ?int
    {
        if (filter_var($data, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) !== null) {
            return (int) $data;
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeBool(?string $data): ?bool
    {
        if (filter_var($data, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) !== null) {
            return (bool) $data;
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeFloat(?string $data): ?float
    {
        if (filter_var($data, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE) !== null) {
            return (float) $data;
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeCpf(?string $data): ?string
    {
        if ($data !== null) {
            return str_replace(['.', '-'], '', trim($data));
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeCnpj(?string $data): ?string
    {
        if ($data !== null) {
            return str_replace(['.', '-', '/'], '', trim($data));
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeTel(?string $data): ?string
    {
        if ($data !== null) {
            return str_replace(['(', ')', '-', ' '], '', trim($data));
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeDatetime(?string $data): ?string
    {
        if ($data !== null) {
            $date = \DateTime::createFromFormat('Y-m-d\TH:i', $data);

            if (!\DateTime::getLastErrors()) {
                return $date->format('Y-m-d H:i:s');
            }
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function sanitizeTime(?string $data): ?string
    {
        if ($data !== null) {
            if (preg_match('/^[\d]{2}:[\d]{2}$/', $data)) {
                return $data;
            }
        }

        return null;
    }

    /**
     * @param string $data
     */
    public static function sanitizeYesNoInput(?string $data): ?bool
    {
        if (($data === 'S') || ($data === 1) || ($data === 'Y')) {
            return true;
        }

        if (($data === 'N') || ($data === 0) || ($data === 'N')) {
            return false;
        }

        return null;
    }

    /**
     * @param ?string $data
     * @return mixed
     */
    public static function sanitizeJson(?string $data)
    {
        if ($decoded = json_decode($data)) {
            return $decoded;
        }

        return null;
    }

    /**
     * @param ?string $data
     */
    public static function escape(?string $data): ?string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, "UTF-8");
    }
}