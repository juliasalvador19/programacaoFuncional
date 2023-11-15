<?php
session_start();
include_once("connection/conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o cartão do banco de dados
    $query = "DELETE FROM cards WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "Cartão excluído com sucesso!";
    } else {
        echo "Erro ao excluir o cartão: " . mysqli_error($conn);
    }

    header("Location: index.php");
} else {
    echo "ID do cartão não fornecido";
}
?>