<?php

namespace Fiado\Helpers;

use Fiado\Enums\InputType;

class FormDataCollector
{
    /**
     * @param string $name
     * @param ?string $default
     * @param InputType $type
     */
    public static function getString(string $name, ?string $default, InputType $type = InputType::Post): ?string
    {
        return filter_input($type->value, $name) ?? $default;
    }

    /**
     * @param string $name
     * @param ?int $default
     * @param InputType $type
     */
    public static function getInt(string $name, ?int $default, InputType $type = InputType::Post): ?int
    {
        return Sanitizer::sanitizeInt(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?float $default
     * @param InputType $type
     */
    public static function getFloat(string $name, ?float $default, InputType $type = InputType::Post): ?float
    {
        return Sanitizer::sanitizeFloat(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?bool $default
     * @param InputType $type
     */
    public static function getBool(string $name, ?bool $default, InputType $type = InputType::Post): ?bool
    {
        return Sanitizer::sanitizeBool(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?string $default
     * @param InputType $type
     */
    public static function getCpf(string $name, ?string $default, InputType $type = InputType::Post): ?string
    {
        return Sanitizer::sanitizeCpf(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?string $default
     * @param InputType $type
     */
    public static function getCnpj(string $name, ?string $default, InputType $type = InputType::Post): ?string
    {
        return Sanitizer::sanitizeCnpj(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?string $default
     * @param InputType $type
     */
    public static function getTelephone(string $name, ?string $default, InputType $type = InputType::Post): ?string
    {
        return Sanitizer::sanitizeTel(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param ?bool $default
     * @param InputType $type
     */
    public static function getYesNoInput(string $name, ?bool $default, InputType $type = InputType::Post): ?bool
    {
        return Sanitizer::sanitizeYesNoInput(filter_input($type->value, $name)) ?? $default;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param InputType $type
     */
    public static function getJsonText(string $name, mixed $default, InputType $type = InputType::Post)
    {
        return Sanitizer::sanitizeJson(filter_input($type->value, $name)) ?? $default;
    }
}