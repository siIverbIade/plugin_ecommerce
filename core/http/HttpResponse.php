<?php

declare(strict_types=1);

namespace Spreng\http;

class HttpResponse
{
    private $url;
    private string $method;
    private $response;
    private $redirect;
    private int $httpcode;

    public function __construct(callable $callback = null, $url = false,  $redirect = false, string $method = 'GET', int $httpcode = 200)
    {
        $this->response = $callback;
        $this->url = $url;
        $this->redirect = $redirect;
        $this->method = $method;
        $this->httpcode = $httpcode;
    }

    public function url()
    {
        return $this->url;
    }

    public function method()
    {
        return $this->method;
    }

    public function response()
    {
        return $this->response;
    }

    public function redirect()
    {
        return $this->redirect;
    }

    public function httpcode()
    {
        return $this->httpcode;
    }
}
