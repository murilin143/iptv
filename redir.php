<?php

require_once("controles/links.php");

if (isset($_GET['acesso']) && isset($_GET['usuario'])) {
    $acesso = $_GET['acesso'];
    $usuario = $_GET['usuario'];
    if ($usuario !== "") {
        if (buscarLink($usuario, $acesso)) {
            header("Location: " . buscarLink($usuario, $acesso)['link_link']);
        } else {
            header('HTTP/1.0 404 Not Found');
        }
    } else {
        header('HTTP/1.0 404 Not Found');
    }
} else {
    header('HTTP/1.0 404 Not Found');
}