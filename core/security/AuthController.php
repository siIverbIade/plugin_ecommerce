<?php

namespace Spreng\security;

use Spreng\http\HttpResponse;
use Spreng\config\GlobalConfig;
use Spreng\http\RequestController;
use App\modelos\templates\page\login;

class AuthController extends RequestController
{
    public static function login()
    {
        $secConf = GlobalConfig::getSecurityConfig();
        $l = new login;
        $l->username = SessionUser::getLogin();
        $l->auth_url = "." . $secConf->authUrl();
        $l->servermsg = Autentication::getAuthMessage();

        return new HttpResponse($secConf->loginUrl(), $l->show());
    }

    public static function checkCredentials()
    {
        $secConf = GlobalConfig::getSecurityConfig();
        if (Autentication::try()) {
            return new HttpResponse($secConf->authUrl(), '', $secConf->startUrl(), 'POST');
        } elseif (Autentication::try() == 'Exception') {
            return new HttpResponse($secConf->authUrl(), '', '/alert', 'POST', 500);
        } else {
            return new HttpResponse($secConf->authUrl(), '', $secConf->loginUrl(), 'POST');
        }
    }

    public static function logout()
    {
        session_unset();
        $secConf = GlobalConfig::getSecurityConfig();
        return new HttpResponse($secConf->logoutUrl(), '', $secConf->loginUrl());
    }
}
