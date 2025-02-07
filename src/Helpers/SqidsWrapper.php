<?php

namespace Fiado\Helpers;

use Sqids\Sqids;

class SqidsWrapper
{
    private static function getInstance(): Sqids
    {
        return new Sqids($_SERVER["SQIDS_ALPHABET"], $_SERVER["SQIDS_MIN_LENGTH"]);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public static function decode(string $id)
    {
        if ($decoded = self::getInstance()->decode($id)) {
            if (self::encode($decoded[0]) == $id) {
                return $decoded[0];
            }
        }

        return null;
    }

    /**
     * @param int $number
     */
    public static function encode(int $number)
    {
        return self::getInstance()->encode([$number]);
    }
}