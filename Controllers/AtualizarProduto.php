<?php
    require '../Models/Connection.php';
    require '../Models/Produto.php';
    
    //Obtendo os valores vindos do formulário de inserção
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $cor = $_POST['cor'];
    $id = $_POST['id'];
    
    //Aplicando as regras de desconto
    if($cor == 'Vermelho' && $preco > 50){
        $preco *= 0.95;
    }else if($cor == 'Vermelho' || $cor == 'Azul'){
        $preco *= 0.8;
    }else if($cor == 'Amarelo'){
        $preco *= 0.9;
    }

    //instanciando a class de conexão e de produto
    $connection = new Connection();
    $produto = new Produto($connection);

    //Atribuindo valores a classe instancianda
    $produto->__set('nome', $nome);
    $produto->__set('preco', $preco);
    $produto->__set('id', $id);

    //Inserindo o registro no banco de dados
    $produto->atualizarProduto();

    //Redirecionando para a página inicial
    header('Location: ../index.php');

?>