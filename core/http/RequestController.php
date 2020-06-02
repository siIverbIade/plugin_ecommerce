<?php

declare(strict_types=1);

namespace Spreng\http;

use Spreng\http\iRequestController;

abstract class RequestController implements iRequestController
{
    protected $rootUrl = '';

    public function getRootUrl(): string
    {
        return $this->rootUrl;
    }

    public static function getFnRoutes(): array
    {
        return array_diff(get_class_methods(get_called_class()), ['getFnRoutes', 'getRootUrl', '__construct']);
    }
}
