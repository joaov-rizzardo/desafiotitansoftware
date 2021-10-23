<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio PHP - Titan Software</title>
    <link rel="stylesheet" href="styles/styles.css">

    <script defer>

    </script>
</head>
<?php
    require './Models/Connection.php';
    require './Models/Produto.php';
?>
<body>
    <main>
        <section id="adicionar">
            <h1>Adicionar produto</h1>
            <form method="post" action="./Controllers/AdicionarProduto.php">
                <input name="nome" type="text" placeholder="Produto">
                <select name="cor">
                    <option value="">-- Cor --</option>
                    <option value="Azul">Azul</option>
                    <option value="Vermelho">Vermelho</option>
                    <option value="Amarelo">Amarelo</option>
                </select>
                <input name="preco" type="number" placeholder="Preço" step="0.01">
                <button>Adicionar</button>
            </form>
        </section>

        <section id="dados">
            <h1>Filtrar produtos</h1>
            <form action="index.php" method="get">
                <input name="nome" type="text" placeholder="Produto">
                <select name="cor">
                    <option value="">Cor</option>
                    <option value="Azul">Azul</option>
                    <option value="Vermelho">Vermelho</option>
                    <option value="Amarelo">Amarelo</option>
                </select>
                <select name="condicao">
                    <option value="maior">Maior ou igual que</option>
                    <option value="menor">Menor ou igual que</option>
                </select>
                <input name="preco" type="number" placeholder="Preço">
                <button>Pesquisar</button>
            </form>
            <h1>Lista de produtos</h1>
            <table style="display: block">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Cor</th>
                        <th>Preço</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        //Instanciando as classes de conexão e de produto
                        $connection = new Connection();
                        $produto = new Produto($connection);
                        
                        //Função que retorna todos os produtos registrados no banco de dados
                        $listaProdutos = $produto->recuperarProdutos();
                        
                        //Listando o retorno do banco na página, e aplicando o filtro se existir
                        foreach($listaProdutos as $produtoDados){
                            if(isset($_GET['nome']) && $_GET['nome'] != '' && $produtoDados->nome != $_GET['nome']){
                                continue;
                            }

                            if(isset($_GET['cor']) && $_GET['cor'] != '' && $produtoDados->cor != $_GET['cor']){
                                continue;
                            }

                            if(isset($_GET['condicao']) && $_GET['condicao'] == 'maior'){

                                if(isset($_GET['preco']) && $_GET['preco'] != '' && $produtoDados->preco < $_GET['preco']){
                                    continue;
                                }

                            }else if(isset($_GET['condicao']) && $_GET['condicao'] == 'menor'){

                                if(isset($_GET['preco']) && $_GET['preco'] != '' && $produtoDados->preco > $_GET['preco']){
                                    continue;
                                }
                            }
                    ?>
                    <tr>
                        <td><?=$produtoDados->nome?></td>
                        <td><?=$produtoDados->cor?></td>
                        <td>R$ <?=$produtoDados->preco?></td>
                        <td><button class="btn-atualizar">Atualizar</button></td>
                        <td><a href="./Controllers/ExcluirProduto.php?id=<?=$produtoDados->id?>" class="btn-excluir">Excluir</a></td>
                    </tr>

                    <?php } ?>
                </tbody>
            </table>
        </section>


    </main>
</body>

</html>