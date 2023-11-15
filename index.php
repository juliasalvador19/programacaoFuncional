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
        <!-- Formulário para adicionar o cartão -->
        <form class="formulario-cartao" action="processa.php" method="post">
            <h3>Adicionar um cartão</h3>
            <label for="titulo">Título</label><br>
            <input class="forms-campo" name="titulo" type="text" autocomplete="off" placeholder="Informe um título..." required><br>
            
            <label for="descricao">Descrição</label><br>
            <input class="forms-campo" name="descricao" type="text" autocomplete="off" placeholder="Informe a descrição..." required><br>

            <label for="situacao">Situação</label><br>
            <select class="forms-campo-situacao" name="situacao" id="situacaoCard" required>
                <option value="" readonly>...</option>
                <option value="Pendente">Pendente</option>
                <option value="Andamento">Andamento</option>
                <option value="Concluído">Concluído</option>
            </select><br>

            <input class="button-enviar" type="submit" value="Enviar">
        </form>

        <?php
            session_start();
            include_once("connection/conexao.php");

            // Buscar os dados da tabela 'Cards' e fazer o filtro de acordo com a situação
            $result_cards = "SELECT * FROM cards";
            $resultado_cards = mysqli_query($conn, $result_cards);

            $cards = [];
            // Percorre os resultados da consulta SQL e adiciona cada linha como um elemento ao array $cards
            while ($row_cards = mysqli_fetch_assoc($resultado_cards)) {
                $cards[] = $row_cards;
            }


              // Filtra os cartões baseados na situação fornecida
            $filterBySituacao = function ($situacao) use ($cards) {
                return array_filter($cards, function ($card) use ($situacao) {
                    return $card['situacao'] === $situacao;
                });
            };

            
            $groupedCards = [
                'Pendente' => $filterBySituacao('Pendente'),
                'Em Andamento' => $filterBySituacao('Andamento'),
                'Concluído' => $filterBySituacao('Concluído'),
            ];
        ?>

        <article>
            <?php
                // Inicia um loop que percorre o array 'groupedCards', onde cada elemento é associado a uma situação (Pendente, Andamento e Concluído)
                // Para cada situação, contém um array de cartões associados a essa situação
                foreach ($groupedCards as $situacao => $cards) {
                    echo "<section>";
                    echo "<h2>{$situacao}</h2>";
                    
                    foreach ($cards as $card) {
                        
                        // Exibir a situação (Pendente = Vermelho | Andamento = Amarelo | Concluído = Verde), título e descrição do cartão
                        echo "<div class=" . $card['situacao'] . "> <svg class=" . $card['situacao'] . " xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z'/></svg><br>";
                        echo "<strong>Titulo:</strong> " . $card['titulo'] . "<br>";
                        echo "<strong>Descricao:</strong> " . $card['descricao'] . "<br>";

                        // Link para editar as informações do cartão
                        echo "<a href='editar.php?id={$card['id']}'>
                                <svg xmlns=http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'>
                                    <style>svg{fill:#ffffff; margin-top: 5px;}</style>
                                        <path d='M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z'/>
                                </svg>
                            </a>";

                        // Link para excluir o cartão
                        echo "<a href='excluir.php?id={$card['id']}'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'>
                                    <style>svg{fill:#ffffff; margin-top: 5px;}</style>
                                        <path d='M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z'/></svg>
                                </a></div>";
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