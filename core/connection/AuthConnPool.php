<?php

declare(strict_types=1);

namespace Spreng\connection;

use Spreng\config\GlobalConfig;
use Spreng\connection\Connection;
use Spreng\config\type\SecurityConfig;

class AuthConnPool extends Connection
{
    public function __construct()
    {
        parent::__construct('auth');
        if ($this->allowRegenerate()) self::createAdmin();
    }

    public static function createAdmin()
    {
        $defaultUser = GlobalConfig::getSecurityConfig()->getDefaultUser();
        $defaultUserName = $defaultUser['username'];
        $defaultPassword = SecurityConfig::bCrypt($defaultUser['password'], 10);
        $ADMIN = self::findOne('usuario', ' BINARY login = ? ', [$defaultUserName]);

        if ($ADMIN == null) {
            //cria as permissões MASTER e USER
            list($MASTERACCESS, $USERACCESS) = self::dispense('permissao', 2);
            $MASTERACCESS->role = 'MASTER';
            $USERACCESS->role = 'USER';

            //cria o grupo MASTER com permissões MASTER e USER
            list($MASTERGROUP, $CONVIDADOGROUP) = self::dispense('grupos', 2);
            $MASTERGROUP->name = 'ADMIN';
            $MASTERGROUP->sharedPermissaoList[] = $MASTERACCESS;
            $MASTERGROUP->sharedPermissaoList[] = $USERACCESS;

            //cria o grupo CONVIDADO com permissões USER
            $CONVIDADOGROUP->name = 'CONVIDADO';
            $CONVIDADOGROUP->sharedPermissaoList[] = $USERACCESS;

            //cria o usuário ADMIN no grupo MASTER, com login/senha salvos em 'default_user'
            $NEWADMIN = self::dispense('usuario');
            $NEWADMIN->login = $defaultUserName;
            $NEWADMIN->senha = $defaultPassword;
            $NEWADMIN->grupo = $MASTERGROUP;

            //cria configurações padrão para conexão do sistema do usuário admin
            $NEWAPPCONFIG = self::dispense('appconfig');
            $NEWAPPCONFIG->url = 'localhost';
            $NEWAPPCONFIG->port = '3306';
            $NEWAPPCONFIG->user = 'root';
            $NEWAPPCONFIG->password = '';
            $NEWAPPCONFIG->usuario = $NEWADMIN;

            self::storeAll([$NEWAPPCONFIG, $CONVIDADOGROUP]);
        } elseif (!$ADMIN['senha'] == $defaultPassword) $ADMIN['senha'] = $defaultPassword;
    }
}
