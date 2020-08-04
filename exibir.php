<?php

require_once('controles/usuarios.php');
require_once('controles/categorias.php');
require_once('controles/listas.php');

header('Content-type: text/plain');

//var_dump($_SERVER['HTTP_USER_AGENT']);
if (isset($_GET["usuario"]) && isset($_GET["lista"])) {
    $usuario = $_GET["usuario"];
    $idlista = $_GET["lista"];
    if ($usuario !== "" && $idlista !== "") {
        $lista = acessoLista($usuario, $idlista);
        if ($lista) {
            if ($lista['global'] == 0) {
                echo $lista['lista'];
            } else {
                $links = listaGlobal($idlista);
                if ($links) {
                    echo "#EXTM3U\n";
                    foreach($links as $link) {
                        echo "\n#EXTINF:-1 tvg-logo=\"{$link['logo']}\" group-title=\"{$link['nome']}\", {$link['nome_link']}\n" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ."redir.php?acesso={$link['acessoLink']}&usuario=$usuario\n";
                    }
                }
            }
        } else {
            echo "#EXTM3U\n#EXTINF:-1 tvg-logo=\"" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") . "img/bloqueado.png\" group-title=\"Acesso Bloqueado!\", Acesso Bloqueado!\nhttp://acessobloqueado.com";
        }
    } else {
        echo "#EXTM3U\n#EXTINF:-1 tvg-logo=\"" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") . "img/bloqueado.png\" group-title=\"Acesso Bloqueado!\", Acesso Bloqueado!\nhttp://acessobloqueado.com";
    }
} else {
    echo "#EXTM3U\n#EXTINF:-1 tvg-logo=\"" . preg_replace('/exibir.php.*/', '', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") . "img/bloqueado.png\" group-title=\"Acesso Bloqueado!\", Acesso Bloqueado!\nhttp://acessobloqueado.com";
}