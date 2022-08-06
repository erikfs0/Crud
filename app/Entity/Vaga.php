<?php

    namespace App\Entity;

    use \App\Db\Database;

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
            $obDatabase->insert([
                'titulo'    => $this->titulo,
                'descricao' => $this->descricao,
                'ativo'     => $this->ativo,
                'data'      => $this->data
            ]);
            //ATRIBUIR O ID NA VAGA NA INSTANCIA


            //RETORNAR SUCESSO
        }
    }
