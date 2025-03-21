<?php

namespace Fiado\Enums;

use Fiado\Helpers\FormDataCollector;

enum FormDataType {
    case String;
    case Int;
    case Float;
    case Bool;
    case Cpf;
    case Cnpj;
    case Telephone;
    case Datetime;
    case Time;
    case YesNoInput;
    case JsonText;

    public function getCallable(): callable
    {
        return match ($this) {
            self::String => FormDataCollector::getString(...),
            self::Int => FormDataCollector::getInt(...),
            self::Float => FormDataCollector::getFloat(...),
            self::Bool => FormDataCollector::getBool(...),
            self::Cpf => FormDataCollector::getCpf(...),
            self::Cnpj => FormDataCollector::getCnpj(...),
            self::Datetime => FormDataCollector::getDatetime(...),
            self::Time => FormDataCollector::getTime(...),
            self::Telephone => FormDataCollector::getTelephone(...),
            self::YesNoInput => FormDataCollector::getYesNoInput(...),
            self::JsonText => FormDataCollector::getJsonText(...),
        };
    }
}