<?php

namespace Spreng\security;

use DateTime;
use Spreng\http\HttpSession;
use Spreng\config\SessionConfig;
use Spreng\security\SessionUser;
use Spreng\connection\AuthConnPool;

class Autentication
{
    public static function setCredentials(HttpSession $session)
    {
        $secConf = SessionConfig::getSecurityConfig();
        if (!self::hasAuthenticated() && !in_array($session->rootRequest(), $secConf->allowedUrls())) {
            header("Location: " . $secConf->loginFullUrl());
            die();
        }
    }

    public static function try()
    {
        $username = HttpSession::username();
        $password = HttpSession::password();

        SessionUser::setLogin($username);

        if ($username == '') {
            self::setAuthMessage('Digite o nome de Usuário');
            return false;
        }

        if ($password == '') {
            self::setAuthMessage('Digite a senha');
            return false;
        }

        $conn = AuthConnPool::start();
        $user = $conn::findOne('usuario', ' BINARY login = ?', [$username]);
        $conn::close();

        if ($user == null) {
            self::setAuthMessage('Usuário não existe!');
            return false;
        }

        if (password_verify($password, $user->senha)) {
            SessionUser::setNome($username);
            SessionUser::setDetalhes('Logou em ' . (new DateTime())->format('d/m/Y'));
            SessionUser::setAuthToken('1293012930129301293');
            self::setAuthMessage('');
            return true;
        } else {
            self::setAuthMessage('Credenciais Inválidas!');
            return false;
        }
    }

    public static function sessionUser(): SessionUser
    {
        return new SessionUser();
    }

    public static function hasAuthenticated(): bool
    {
        return isset($_SESSION['usuario']['authtoken']);
    }

    public static function getAuthMessage()
    {
        return isset($_SESSION['authmessage']) ? $_SESSION['authmessage'] : '';
    }

    public static function setAuthMessage(string $message)
    {
        $_SESSION['authmessage'] = $message;
    }
}
