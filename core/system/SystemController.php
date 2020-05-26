<?php

namespace Spreng\system;

use Spreng\system\System;
use Spreng\http\HttpResponse;
use Spreng\http\RequestController;

class SystemController extends RequestController
{
    public static function message()
    {
        return new HttpResponse('/alert', System::Message());
    }
}
