<?php
session_start();
include_once("connection/conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $novoTitulo = $_POST['titulo'];
        $novaDescricao = $_POST['descricao'];
        $novaSituacao = $_POST['situacao'];

        // Atualiza os dados do cartão no banco de dados
        $query = "UPDATE cards SET titulo = '$novoTitulo', descricao = '$novaDescricao', situacao = '$novaSituacao' WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            echo "Cartão atualizado com sucesso!";
            
            header("Location: index.php"); // Voltar para a página index.php
        } else {
            echo "Erro ao atualizar o cartão: " . mysqli_error($conn);
        }
    }

    // Recupera os dados do cartão
    $query = "SELECT * FROM cards WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $card = mysqli_fetch_assoc($result);
    } else {
        echo "Erro ao buscar o cartão";
        exit;
    }
} else {
    echo "ID do cartão não fornecido"; // Ocorre esse aviso se o ID não for fornecido (Por exemplo, se acessar direto a página editar.php sem o parâmetro ID) 
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trello</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="shortcut icon" href="assets/icone.png" type="image/png">
</head>
<body>
    <header class="home">
        <nav>
            <a class="home-logo" href="index.php">
                <img src="assets/icone.png" alt="Imagem da logo do Trello">
                Trello
            </a>
        </nav>
    </header>

    <main>
        <!-- Formulário para editar  o cartão -->
        <form class="formulario-cartao" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="post">
            <h3>Editar Cartão</h3>
            <input class="forms-campo" type="hidden" name="id" value="<?php echo $card['id']; ?>">

            <label for="titulo">Título</label><br>
            <input class="forms-campo" name="titulo" type="text" autocomplete="off" value="<?php echo $card['titulo']; ?>" required><br>

            <label for="descricao">Descrição</label><br>
            <input class="forms-campo" name="descricao" type="text" autocomplete="off" value="<?php echo $card['descricao']; ?>" required><br>

            <label for="situacao">Situação</label><br>
            <select class="forms-campo-situacao" name="situacao" id="situacaoCard" required>
                <option value="Pendente" <?php echo ($card['situacao'] === 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                <option value="Andamento" <?php echo ($card['situacao'] === 'Andamento') ? 'selected' : ''; ?>>Andamento</option>
                <option value="Concluído" <?php echo ($card['situacao'] === 'Concluído') ? 'selected' : ''; ?>>Concluído</option>
            </select><br>

            <input class="button-enviar" type="submit" value="Enviar">
        </form>
    </main>

    <footer class="home-rodape-editar centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen </small>
    </footer>

</body>
</html>