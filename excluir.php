<?php

    session_start();
    include_once("connection/conexao.php");

    // Verifica se o ID foi informado
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Exclui o cartão do banco de dados
        $query = "DELETE FROM cards WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            echo "Cartão excluído com sucesso!";
        } else {
            echo "Erro ao excluir o cartão: " . mysqli_error($conn);
        }

        header("Location: index.php"); // Voltar para a página index.php
    } else {
        echo "ID do cartão não fornecido"; // Ocorre esse aviso se o ID não for fornecido (Por exemplo, se acessar direto a página excluir.php sem o parâmetro ID) 
    }
