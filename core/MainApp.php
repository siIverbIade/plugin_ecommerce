<?php

declare(strict_types=1);

namespace Spreng;

use Spreng\http\HttpSession;
use Spreng\config\GlobalConfig;
use Spreng\http\RequestHandler;
use Spreng\security\Autentication;

abstract class MainApp
{
    public static function init()
    {
        $session = new HttpSession();
        Autentication::setCredentials($session);
        echo (new RequestHandler($session))->processRequest();
    }

    public function config()
    {
        return new GlobalConfig;
    }
}
