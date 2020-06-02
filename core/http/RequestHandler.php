<?php

declare(strict_types=1);

namespace Spreng\http;

use Spreng\config\GlobalConfig;
use Spreng\system\utils\FileUtils;
use Spreng\security\AuthController;
use Spreng\system\SystemController;
use Spreng\system\Collections\ControllerList;

class RequestHandler
{
    private HttpSession $session;
    private ControllerList $controllers;
    private array $classes;

    public function __construct(HttpSession $session)
    {
        $this->session = $session;
        $this->controllers = new ControllerList();
        $this->classes = GlobalConfig::getAllImplementationsOf(GlobalConfig::getHttpConfig()->getControllersPath(), 'Spreng\http\RequestController');
        $this->registerAll();
    }

    private function fullUrl($url): string
    {
        return $this->session::rootUrl() . $url;
    }

    private function registerAll()
    {
        $this->controllers->addController(new AuthController);
        $this->controllers->addController(new SystemController);
        foreach ($this->classes as $class => $parentClass) {
            $this->controllers->addController(new $class);
        }
    }

    public function processRequest()
    {
        foreach ($this->controllers->getAll() as $ctl) {
            $ctlShifted = $ctl->getFnRoutes();
            //$class = strtolower(str_replace('Main', '', str_replace('Controller', '', FileUtils::fileName($ctlShifted[0]))));
            //array_shift($ctlShifted);
            foreach ($ctlShifted as $name) {
                $response = $ctl->{$name}();
                $fullUrl = $this->fullUrl($ctl->getRootUrl() . $response->url());
                $method = $response->method();
                if ($fullUrl == $this->session->rootRequest()) {
                    //echo $fullUrl . "</br>";
                    //echo $this->session->rootRequest() . "</br>";
                    if ($method !== $this->session::method()) {
                        http_response_code(405);
                        return "<h1>ERRO 405 (Método não suportado)</h1><button onclick='window.history.back();'>Voltar</button>";
                    }

                    http_response_code($response->httpcode());

                    if ($response->redirect() == false) {
                        return $response->response()();
                    } else {
                        if (!$response->response() == null) $response->response()();
                        header("Location: " . $this->fullUrl($response->redirect()));
                        exit;
                    }
                }
            }
        }
        http_response_code(404);
        return "<h1>ERRO 404 (Não Encontrado)</h1><button onclick='window.history.back();'>Voltar</button>";
    }
}
