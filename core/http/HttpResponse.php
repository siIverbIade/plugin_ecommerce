<?php

declare(strict_types=1);

namespace Spreng\http;

class HttpResponse
{
    private string $url;
    private string $method;
    private string $response;
    private $redirect;
    private int $httpcode;

    public function __construct(string $url, string $response, $redirect = false, string $method = 'GET', int $httpcode = 200)
    {
        $this->url = $url;
        $this->method = $method;
        $this->redirect = $redirect;
        $this->response = $response;
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
