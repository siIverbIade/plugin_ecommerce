<?php

declare(strict_types=1);

namespace Spreng\http;

use Spreng\http\iRequestController;

abstract class RequestController implements iRequestController
{
    public static function getFnRoutes(): array
    {
        return array_diff(get_class_methods(get_called_class()), ['getFnRoutes']);
    }
}
