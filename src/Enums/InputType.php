<?php

namespace Fiado\Enums;

enum InputType: int {
    case Get = INPUT_GET;
    case Post = INPUT_POST;
}