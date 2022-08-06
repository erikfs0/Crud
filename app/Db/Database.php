<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database {
    /**
     *  HOST DE CONEXÃO COM O BANCO DE DADOS
     */
    const HOST = 'localhost';

    /**
     * NOME DO BANCO DE DADOS
     * @var string
     */
    const NAME = 'wdev_vagas';

    /**
     * USUÁRIO DO BANCO
     * @var string
     */
    const USER = 'root';
    /**
     * SENHA DE ACESSO AO BANCO DE DADOS
     *  @var string
     */
    const PASS = ''; //MEU BD NAO TEM SENHA!!!
    /**
     * NOME DA TABELA A SER MANIPULADO
     * @var string
     */
    private $table;

    /**
     * INSTANCIA DE CONEXÃO COM O BANDO DE DADOS
     * @var PDO
     */
    private $connection;

    /**
     * DEFINE A TABELA E INSTANCIA E CONEXÃO
     * @param string $table
     */
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }
    /**
     * MÉTODO RESPONSAVEL POR CRIAR UMA CONEXÃO COM O BANCO DE DADOS
     */
    private function setConnection(){
        try{
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
     * MÉTOdO RESPONSAVEL POR INSERIR DADOS NO BANCO
     * @param array $values [field => value]
     * @return integer
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);
       /* echo "<pre>"; print_r($fields); echo "</pre>"; exit;------Debug para testar*/
        $binds = array_pad([],count($fields),'?');

        //MONTA A QUERY       
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
        
    }
}