<?php
require '../Models/Connection.php';
require '../Models/Produto.php';
    if(isset($_GET['id'])){
        
        //recuperando o valor do id do produto a ser excluido
        $id = $_GET['id'];

        //instanciando as classes de conexão e de produto
        $connection = new Connection();
        $produto = new Produto($connection);

        //setando o id do produto
        $produto->__set('id', $id);

        //executando a função para excluir o produto
        $produto->excluirProduto();

        //redirecionando para a página inicial
        header('Location: ../index.php');
    }
?>