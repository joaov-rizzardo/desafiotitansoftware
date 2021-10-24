<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio PHP - Titan Software</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function atualizar(id,nome,cor,preco){
            //exibindo o modal na tela e setando os valores correspondentes ao produto
            const modal = document.getElementById('modal-div')
            document.getElementById('modalId').value = id
            document.getElementById('modalNome').value = nome
            document.getElementById('modalCor').value = cor
            document.getElementById('modalPreco').value = preco
            modal.style.display = 'flex'

		}

        function fecharModal(){
            const modal = document.getElementById('modal-div')
            modal.style.display = 'none'
        }

    </script>
</head>
<?php
require './Models/Connection.php';
require './Models/Produto.php';
?>

<body>
    <h1>Desafio PHP Titan Software<i class="fas fa-code"></i></h1>
    <main>
        <section id="adicionar">
            <h2>Adicionar produto</h2>
            <form method="post" action="./Controllers/AdicionarProduto.php">
                <input name="nome" type="text" placeholder="Produto">
                <select name="cor">
                    <option value="">Cor</option>
                    <option value="Azul">Azul</option>
                    <option value="Vermelho">Vermelho</option>
                    <option value="Amarelo">Amarelo</option>
                    <option value="Preto">Preto</option>
                    <option value="Verde">Verde</option>
                    <option value="Laranja">Laranja</option>
                    <option value="Rosa">Rosa</option>
                </select>
                <input name="preco" type="number" placeholder="Preço" step="0.01">
                <button type="submit">Adicionar<i class="fas fa-plus-circle"></i></button>
            </form>
        </section>

        <section id="dados">
            <h2>Filtrar produtos</h2>
            <form action="index.php" method="get">
                <input name="nome" type="text" placeholder="Produto">
                <select name="cor">
                    <option value="">Cor</option>
                    <option value="Azul">Azul</option>
                    <option value="Vermelho">Vermelho</option>
                    <option value="Amarelo">Amarelo</option>
                    <option value="Preto">Preto</option>
                    <option value="Verde">Verde</option>
                    <option value="Laranja">Laranja</option>
                    <option value="Rosa">Rosa</option>
                </select>
                <select name="condicao">
                    <option value="maior">Maior ou igual que</option>
                    <option value="menor">Menor ou igual que</option>
                </select>
                <input name="preco" type="number" placeholder="Preço">
                <button>Pesquisar<i class="fas fa-search"></i></button>
            </form>
            
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
                    foreach ($listaProdutos as $produtoDados) {
                        if (isset($_GET['nome']) && $_GET['nome'] != '' && $produtoDados->nome != $_GET['nome']) {
                            continue;
                        }

                        if (isset($_GET['cor']) && $_GET['cor'] != '' && $produtoDados->cor != $_GET['cor']) {
                            continue;
                        }

                        if (isset($_GET['condicao']) && $_GET['condicao'] == 'maior') {

                            if (isset($_GET['preco']) && $_GET['preco'] != '' && $produtoDados->preco < $_GET['preco']) {
                                continue;
                            }
                        } else if (isset($_GET['condicao']) && $_GET['condicao'] == 'menor') {

                            if (isset($_GET['preco']) && $_GET['preco'] != '' && $produtoDados->preco > $_GET['preco']) {
                                continue;
                            }
                        }
                    ?>
                        <tr>
                            <td><?= $produtoDados->nome ?></td>
                            <td><?= $produtoDados->cor ?></td>
                            <td>R$ <?= $produtoDados->preco ?></td>
                            <td><button onclick="atualizar(<?=$produtoDados->id?>,'<?=$produtoDados->nome?>','<?=$produtoDados->cor?>',<?=$produtoDados->preco?>)" class="btn-atualizar">Atualizar<i class="fas fa-edit"></i></button></td>
                            <td><a href="./Controllers/ExcluirProduto.php?id=<?= $produtoDados->id ?>" class="btn-excluir">Excluir<i class="fas fa-trash"></i></a></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    

    <!-- Modal para atualização dos produtos -->
    <div id="modal-div">
        <div id="modal">
            <div id="atualizar">   
                <h3>Atualizar produto</h3>
                <button onclick="fecharModal()"><i class="far fa-window-close"></i></button>
            </div>
            
            <form action="./Controllers/AtualizarProduto.php" method="post">
                <input name="id" id="modalId" type="hidden">
                <input name="nome" id="modalNome" type="text">
                <input name="cor" id="modalCor" type="text" readonly="readonly">
                <input name="preco" id="modalPreco" type="number" step="0.01">
                <button class="btn-atualizar" type="submit">Atualizar <i class="fas fa-edit"></i></button>
            </form>
        </div>
    </div>
</body>

</html>