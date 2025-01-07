<?php

namespace Fiado\Enums;

enum ValidatorErrorType {
    case Required;
    case NotEmpty;
    case InvalidEmail;
    case InvalidCpf;
    case InvalidCnpj;
    case InvalidDate;
    case InvalidePhoneNumber;
    case InvalidFormat;
    case InvalidValue;
    case InvalidInstance;
    case NonBoolean;
    case NonNumeric;
    case NotEqual;
    case NotUnique;
    case ValueTooHigh;
    case ValueTooLow;
    case LengthTooLong;
    case LengthTooShort;
    case NotInRange;
    case AlreadyExists;
    case DoesNotExist;
}