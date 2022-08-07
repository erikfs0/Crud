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
     * MÉTODO RESPONSÁVEL POR EXECUTAR queries  DENTRO DO BANCO DE DADOS
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute ($query,$params = []){
        try {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }
    /**
     * MÉTOdO RESPONSAVEL POR INSERIR DADOS NO BANCO
     * @param array $values [field => value]
     * @return integer ID INSERIDO
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);
       /* echo "<pre>"; print_r($fields); echo "</pre>"; exit;------Debug para testar*/
        $binds = array_pad([],count($fields),'?');

        //MONTA A QUERY       
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
        
        //EXECUTA O INSERT
        $this->execute($query,array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->LastInsertId();
    }
    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR UMA CONSULTA NO BANCO
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    /**
     * MÉTODO RESPONSÁVEL POR EXECUTAR ATUALIZAR NO BANCO DE DADOS
     * @param string $where
     * @param array $values [field => value]
     * @return boolean
     */
    public function update ($where,$values){
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
        
        //EXECUTAR A QUERY
        $this->execute($query,array_values($values));

        return true;
    }
    /**
     * MÉTODO RESPONSAVEL POR EXCLUIR DADOS
     * @param string $where
     * @return boolean
     */

     public function delete($where){
         //MONTA A QUERY
         $query ='DELETE FROM '.$this->table.' WHERE '.$where;

         //EXECUTA A QUERY
         $this->execute($query);

         //RETORNA SUCESSO
         return true;
     }
}