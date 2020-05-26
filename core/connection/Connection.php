<?php

declare(strict_types=1);

namespace Spreng\connection;

require_once 'rb.php';

use Exception;
use R;
use PDO;
use PDOException;

class Connection extends R
{
    private $enderecoDB; //endereço do mysql
    private $nomeDB; //nome do banco
    private $usuarioDB; //nome de usuário
    private $senhaDB; //senha de acesso

    public function __construct(string $endereco, string $nome, string $usuario, string $senha = "", bool $conecta = true)
    {
        $this->enderecoDB = $endereco; //endereço do mysql
        $this->nomeDB = $nome; //nome do banco
        $this->usuarioDB = $usuario; //nome de usuário
        $this->senhaDB = $senha; //senha de acesso

        if ($conecta) {
            self::conectaDB();
        }
    }

    public function conectaDB()
    {
        if (!self::testConnection()) self::setup("mysql:host=" . $this->enderecoDB . ";dbname=" . $this->nomeDB, $this->usuarioDB, $this->senhaDB);
        /*
        if (self::testConnection()) { //testa se a conexão foi bem sucedida
            //echo "Conexão bem sucedida!\n";
            return true;
        } else {
            //echo "Falha na conexão!!\n";
            self::close();
            return false;
        }*/
    }

    public function getConnectionLog(): string
    {
        try {
            $db = new PDO("mysql:host=" . $this->enderecoDB . ";dbname=" . $this->nomeDB, $this->usuarioDB, $this->senhaDB);
            $return = "OK";
        } catch (PDOException $e) {
            $return = $e->getmessage();
        }
        return $return;
    }

    public function getEndereco(): string
    {
        return $this->enderecoDB;
    }
    public function getNome(): string
    {
        return $this->nomeDB;
    }
    public function getUsuario(): string
    {
        return $this->usuarioDB;
    }
    public function getSenha(): string
    {
        return $this->senhaDB;
    }

    public function setEndereco(string $endereco)
    {
        $this->enderecoDB = $endereco;
        self::conectaDB($this->enderecoDB, $this->nomeDB, $this->usuarioDB, $this->senhaDB);
    }

    public function setNome(string $nome)
    {
        $this->nomeDB = $nome;
        self::conectaDB($this->enderecoDB, $this->nomeDB, $this->usuarioDB, $this->senhaDB);
    }

    public function setUsuario(string $usuario)
    {
        $this->usuarioDB = $usuario;
        self::conectaDB($this->enderecoDB, $this->nomeDB, $this->usuarioDB, $this->senhaDB);
    }

    public function setSenha(string $senha)
    {
        $this->senhaDB = $senha;
        self::conectaDB($this->enderecoDB, $this->nomeDB, $this->usuarioDB, $this->senhaDB);
    }

    public static function persist($obj)
    {
        self::store(self::dispense($obj)); // persiste a entidade com o RedBean
    }

    public static function persistIndex($indexValue, string $indexName, $obj)
    {
        $load = self::findOne($obj['_type'], "$indexName = ?", [$indexValue]);
        if (is_null($load)) {
            self::persist($obj);
            return $obj;
        } else {

            foreach ($obj as $fld => $val) {
                if ($fld !== "_type") $load[$fld] = $val;
            }
            self::store($load);
            return $load;
        }
    }
}
