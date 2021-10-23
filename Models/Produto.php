<?php
    class Produto{
        private $id;
        private $produto;
        private $cor;
        private $preco;
        private $connection;

        public function __construct(Connection $connection){
            $this->connection = $connection->connect();
        }

        public function __get($attr){
            return $this->$attr;
        }

        public function __set($attr, $value){
            $this->$attr = $value;
        }

        //Função para inserir um novo produto
        public function inserirProduto(){
            $query = 'insert into produtos(nome, cor, preco)values(:nome,:cor,:preco)';
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':cor', $this->__get('cor'));
            $stmt->bindValue(':preco', $this->__get('preco'));

            $stmt->execute();

        }

        //Função para recuperar os todos produtos do banco de dados
        public function recuperarProdutos(){
            $query = 'select * from produtos';
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function excluirProduto(){
            $query = 'delete from produtos where id = :id';
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));

            $stmt->execute();
        }
    }

?>