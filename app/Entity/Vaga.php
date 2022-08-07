<?php

    namespace App\Entity;

    use \App\Db\Database;
    use \PDO;
    //crio a class vaga

    class Vaga{

        /**
         * Indentificador único da vaga
         * @var integer
         */
        public $id;

        /**
         * Título da vaga
         * @var string
         */
        public $titulo;

        /**
         * Descrição da vaga (pode conter html)
         * @var string
         */
        public $descricao;

        /**
         * Define se a vaga ativa
         * @var string(s/n)
         */
        public $ativo;

        /**
         * Data de publicação da vaga
         * @var string
         */
        public $data;

        /**
         * Método responsavel por cadastrar uma nova vaga no banco
         * @return boolean
         */
        public function cadastrar(){
            //DEFINIR A DATA
            $this->data = date('Y-m-d: H:i:s');
            
            //INSERIRI A VAGA NO BANCO
            $obDatabase = new Database('vagas');
            $this->id = $obDatabase->insert([
                'titulo'    => $this->titulo,
                'descricao' => $this->descricao,
                'ativo'     => $this->ativo,
                'data'      => $this->data
            ]);
           
            //RETORNAR SUCESSO
            return true;
        }
        /**
         *MÉTODO RESPONSÁVEL POR ATUALIZAR A VAGA NO BANCO
         * @return boolean
         */
        public function atualizar(){
            return(new Database('vagas'))->update('id = '.$this->id,[
                'titulo'    => $this->titulo,
                'descricao' => $this->descricao,
                'ativo'     => $this->ativo,
                'data'      => $this->data
            ]);  
        }
        /**
         * MÉTODO RESPONSÁVEL POR EXCLUIR A VAGA DO BANCO
         * @return boolean
         */
        public function excluir(){
            return (new Database('vagas'))->delete('id = '.$this->id);
        }

        /**
         * MÉTODO RESPONSÁVEL POR OBTER AS VAGAS DO BANCO DE DADO
         * @param string $where
         * @param string $order
         * @param string $limit
         * @return array
         */
        public static function getVagas ($where = null, $order = null, $limit = null){
            return(new Database('vagas'))->select($where,$order,$limit)
                                         ->fetchAll(PDO::FETCH_CLASS,self::class);
        }
        /**
         * MÉTOFO RESPONSÁVEL POR BUSCAR UMA VAGA COM BASE EM SEU ID
         * @param integer $id
         * @return Vaga
         */
        public static function getVaga($id){
            return(new Database('vagas'))->select('id ='.$id)
                                         ->fetchObject(self::class);  
        }
    }
