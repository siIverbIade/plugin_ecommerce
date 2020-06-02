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
        return new HttpResponse(function () {
            $secConf = GlobalConfig::getSecurityConfig();
            $l = new login;
            $l->username = SessionUser::getLogin();
            $l->auth_url = "." . $secConf->authUrl();
            $l->servermsg = Autentication::getAuthMessage();
            return $l->show();
        }, $secConf->loginUrl());
    }

    public static function checkCredentials()
    {
        $secConf = GlobalConfig::getSecurityConfig();
        if (Autentication::try()) {
            return new HttpResponse(null, $secConf->authUrl(), $secConf->startUrl(), 'POST');
        } elseif (Autentication::try() == 'Exception') {
            return new HttpResponse(null, $secConf->authUrl(), '/alert', 'POST', 500);
        } else {
            return new HttpResponse(null, $secConf->authUrl(), $secConf->loginUrl(), 'POST');
        }
    }

    public static function logout()
    {
        $secConf = GlobalConfig::getSecurityConfig();
        return new HttpResponse(function () {
            session_unset();
        }, $secConf->logoutUrl(), $secConf->loginUrl());
    }
}
