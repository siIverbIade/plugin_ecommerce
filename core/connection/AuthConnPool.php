<?php

declare(strict_types=1);

namespace Spreng\connection;

use Spreng\connection\Database;
use Spreng\config\SessionConfig;
use Spreng\connection\Connection;
use Spreng\config\type\SecurityConfig;

class AuthConnPool
{
    public static function start(): Connection
    {
        $param = SessionConfig::getConnectionConfig();
        $regenerate = $param->getRegenerate('auth');
        $conn = new Connection($param->getUrl('auth') . ":" . $param->getPort('auth'), $param->getDatabase('auth'), $param->getUser('auth'), $param->getPassword('auth'), !$regenerate);
        if ($regenerate) {
            Database::new($param->getUrl('auth') . ":" . $param->getPort('auth'), $param->getDatabase('auth'), $param->getUser('auth'), $param->getPassword('auth'));
            $conn->conectaDB();
            $ADMIN = $conn::findOne('usuario', ' login = ? ', ['ADMIN']);

            if ($ADMIN == null) {
                //cria as permissões MASTER e USER
                list($MASTERACCESS, $USERACCESS) = $conn::dispense('permissao', 2);
                $MASTERACCESS->role = 'MASTER';
                $USERACCESS->role = 'USER';

                //cria o grupo MASTER com permissões MASTER e USER
                list($MASTERGROUP, $CONVIDADOGROUP) = $conn::dispense('grupos', 2);
                $MASTERGROUP->name = 'ADMIN';
                $MASTERGROUP->sharedPermissaoList[] = $MASTERACCESS;
                $MASTERGROUP->sharedPermissaoList[] = $USERACCESS;

                //cria o grupo CONVIDADO com permissões USER
                $CONVIDADOGROUP->name = 'CONVIDADO';
                $CONVIDADOGROUP->sharedPermissaoList[] = $USERACCESS;

                //cria o usuário ADMIN no grupo MASTER, com login/senha salvos em 'default_user'
                $NEWADMIN = $conn::dispense('usuario');
                $defaultUser = SessionConfig::getSecurityConfig()->getDefaultUser();
                $NEWADMIN->login = $defaultUser['username'];
                $NEWADMIN->senha = SecurityConfig::bCrypt($defaultUser['password'], 10);
                $NEWADMIN->grupo = $MASTERGROUP;

                //cria configurações padrão para conexão do sistema do usuário admin
                $NEWAPPCONFIG = $conn::dispense('appconfig');
                $NEWAPPCONFIG->url = 'localhost';
                $NEWAPPCONFIG->port = '3306';
                $NEWAPPCONFIG->user = 'root';
                $NEWAPPCONFIG->password = '';
                $NEWAPPCONFIG->usuario = $NEWADMIN;

                $conn::storeAll([$NEWAPPCONFIG, $CONVIDADOGROUP]);
            }
        }

        return $conn;
    }
}
