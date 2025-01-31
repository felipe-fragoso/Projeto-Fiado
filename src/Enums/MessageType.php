<?php

namespace Fiado\Enums;

enum MessageType {
    case Success;
    case Warning;
    case Error;
    case Info;
}