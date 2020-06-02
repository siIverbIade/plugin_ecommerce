<?php

declare(strict_types=1);

namespace Spreng\config\type;

use Spreng\http\HttpSession;
use Spreng\config\type\Config;

class SecurityConfig extends Config
{
    private string $root_url;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->root_url = HttpSession::rootUrl();
    }

    public static function bCrypt(string $password, int $cost): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    private function getRootUrl(): string
    {
        return $this->root_url ? "/" . basename($this->root_url) : '';
    }

    public function loginUrl(): string
    {
        return $this->getOneConfig('login_url');
    }

    public function authUrl(): string
    {
        return $this->getOneConfig('auth_url');
    }

    public function startUrl(): string
    {
        return $this->getOneConfig('start_url');
    }

    public function logoutUrl(): string
    {
        return $this->getOneConfig('logout_url');
    }

    public function loginFullUrl(): string
    {
        return $this->getRootUrl() . $this->getOneConfig('login_url');
    }

    public function authFullUrl(): string
    {
        return $this->getRootUrl() . $this->getOneConfig('auth_url');
    }

    public function startFullUrl(): string
    {
        return $this->getRootUrl() . $this->getOneConfig('start_url');
    }

    public function logoutFullUrl(): string
    {
        return $this->getRootUrl() . $this->getOneConfig('logout_url');
    }

    private function fullAllowedUrlsAray(): array
    {
        return array_map(function ($url) {
            return $this->getRootUrl() . $url;
        }, $this->getOneConfig('allowed_urls'));
    }

    public function allowedUrls(): array
    {
        return [...$this->fullAllowedUrlsAray(), $this->loginFullUrl(), $this->authFullUrl(), $this->getRootUrl() . '/alert'];
    }

    public function getDefaultUser(): array
    {
        return $this->getOneConfig('default_user');
    }
}
