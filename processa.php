<?php

session_start();
include_once("connection/conexao.php");


$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

$result_cards = "INSERT INTO cards (titulo, descricao) VALUES ('$titulo', '$descricao')";
$resultado_cards = mysqli_query($conn, $result_cards);

if(mysqli_insert_id($conn)){
    header("Location: index.php");
} else {
    header("Location: index.php");
}

