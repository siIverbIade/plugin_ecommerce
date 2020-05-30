<?php

declare(strict_types=1);

namespace Spreng\http;

use Spreng\config\GlobalConfig;
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

    private function fullUrl(string $url): string
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
            foreach ($ctl->getFnRoutes() as $name) {
                $route = $ctl->{$name}();
                $fullUrl = $this->fullUrl($route->url());
                $method = $route->method();
                if ($fullUrl == $this->session->rootRequest()) {
                    if ($method !== $this->session::method()) {
                        http_response_code(405);
                        return "<h1>ERRO 405 (Método não suportado)</h1><button onclick='window.history.back();'>Voltar</button>";
                    }
                    http_response_code($route->httpcode());

                    if ($route->redirect() == false) {
                        return $route->response();
                    } else {
                        header("Location: " . $this->fullUrl($route->redirect()));
                        exit;
                    }
                }
            }
        }
        http_response_code(404);
        return "<h1>ERRO 404 (Não Encontrado)</h1><button onclick='window.history.back();'>Voltar</button>";
    }
}
