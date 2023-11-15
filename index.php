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
        <form class="formulario-cartao" action="processa.php" method="post">
            <h3>Adicionar um cartão</h3>
            <label for="titulo">Informe um título</label><br>
            <input name="titulo" type="text" autocomplete="off" placeholder="Informe um título..." required><br>
            <label for="situacao">Informe a situação</label><br>
            <select name="descricao" id="situacaoCard" required>
                <option value="" readonly>...</option>
                <option value="Pendente">Pendente</option>
                <option value="Andamento">Andamento</option>
                <option value="Concluído">Concluído</option>
            </select><br>
            <input type="submit" value="Enviar">
        </form>
        <br><br><br>

        <?php
    session_start();
    include_once("connection/conexao.php");

    $result_cards = "SELECT * FROM cards";
    $resultado_cards = mysqli_query($conn, $result_cards);

    // Fetch all rows
    $cards = [];
    while ($row_cards = mysqli_fetch_assoc($resultado_cards)) {
        $cards[] = $row_cards;
    }

    // Function to filter cards based on 'descricao'
    $filterByDescricao = function ($descricao) use ($cards) {
        return array_filter($cards, function ($card) use ($descricao) {
            return $card['descricao'] === $descricao;
        });
    };

    
    $groupedCards = [
        'Pendente' => $filterByDescricao('Pendente'),
        'Em Andamento' => $filterByDescricao('Andamento'),
        'Concluído' => $filterByDescricao('Concluído'),
    ];
?>

<article>
    <?php
        foreach ($groupedCards as $descricao => $cards) {
            echo "<section>";
            echo "<h2>{$descricao}</h2>";
            
            foreach ($cards as $card) {
                echo "<div class=" . $card['descricao'] . ">Titulo: " . $card['titulo'] . "<br>";
                echo "Descricao: " . $card['descricao'] . "</div><br>";
            }

            echo "</section>";
        }
    ?>
</article>
    </main>

    <footer class="home-rodape centraliza">
        <small>Todos os direitos reservados &copy 2023 &reg Julia Salvador e Mariana Dircksen </small>
    </footer>
    
</body>
</html>