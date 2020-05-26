<?php

declare(strict_types=1);

namespace Spreng\http;

class HttpSession
{
    private array $urlParse;
    public function __construct()
    {
        $this->urlParse = parse_url($_SERVER['REQUEST_URI']);
        self::initSession();
    }

    public static function initSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function rootUrl(): string
    {
        return '/' . explode('/', $_SERVER['REQUEST_URI'])[1];
    }

    public static function fullUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function rootRequest()
    {
        return $this->urlParse['path'];
    }

    public function urlParameters(): array
    {
        $params = [];
        if (isset($this->urlParse['query'])) parse_str($this->urlParse['query'], $params);
        return $params;
    }

    public static function urlParameter(string $name): string
    {
        return self::urlParameters()[$name];
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function body()
    {
        return file_get_contents("php://input");
    }

    public static function username()
    {
        if (isset($_POST['username'])) {
            $_SESSION['auth']['username'] = $_POST['username'];
        }

        return isset($_SESSION['auth']['username']) ? $_SESSION['auth']['username'] : false;
    }

    public static function password()
    {
        if (isset($_POST['password'])) {
            $_SESSION['auth']['password'] = $_POST['password'];
        }

        return isset($_SESSION['auth']['password']) ? $_SESSION['auth']['password'] : false;
    }
}
