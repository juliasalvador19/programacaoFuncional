<?php

    session_start();
    include_once("connection/conexao.php");

    // Pega os valores dos campos enviados via POST
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_STRING);

    // Inserir o título, descrição e situação na tabela cards
    $result_cards = "INSERT INTO cards (titulo, descricao, situacao) VALUES ('$titulo', '$descricao', '$situacao')";
    $resultado_cards = mysqli_query($conn, $result_cards);

    if(mysqli_insert_id($conn)){
        header("Location: index.php"); // Voltar para a página index.php
    } else {
        header("Location: index.php"); // Voltar para a página index.php
    }

