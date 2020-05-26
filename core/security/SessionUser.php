<?php

namespace Spreng\security;

class SessionUser
{
    public static function getNome()
    {
        return isset($_SESSION['usuario']['nome']) ? $_SESSION['usuario']['nome'] : 'nome????';
    }

    public static function setNome(string $nome)
    {
        $_SESSION['usuario']['nome'] = $nome;
    }

    public static function getLogin()
    {
        return isset($_SESSION['usuario']['login']) ? $_SESSION['usuario']['login'] : '';
    }

    public static function setLogin(string $login)
    {
        $_SESSION['usuario']['login'] = $login;
    }

    public static function getSenha()
    {
        return isset($_SESSION['usuario']['senha']) ? $_SESSION['usuario']['senha'] : '';
    }

    public static function setSenha(string $login)
    {
        $_SESSION['usuario']['senha'] = $login;
    }


    public static function getDetalhes()
    {
        return isset($_SESSION['usuario']['detalhes']) ? $_SESSION['usuario']['detalhes'] : '';
    }

    public static function setDetalhes(string $detalhes)
    {
        $_SESSION['usuario']['detalhes'] = $detalhes;
    }

    public static function getAuthToken()
    {
        return $_SESSION['usuario']['authtoken'];
    }

    public static function setAuthToken(string $authToken)
    {
        $_SESSION['usuario']['authtoken'] = $authToken;
    }

    public static function AppConfig(string $arg)
    {
        return self::getConnParam()[$arg];
    }

    public static function setAppConfig(array $appConfig)
    {
        $_SESSION['usuario']['appconfig'] = $appConfig;
    }

    public static function getConnParam(): array
    {
        return isset($_SESSION['usuario']['appconfig']) ? $_SESSION['usuario']['appconfig'] : [
            'url' => 'localhost',
            'port' => '3306',
            'database' => 'database',
            'user' => self::getLogin(),
            'password' => '',
        ];
    }
}
