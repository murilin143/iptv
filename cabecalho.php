<?php
error_reporting(0);
if (basename($_SERVER["PHP_SELF"]) === basename(__FILE__)) {
    header('HTTP/1.0 403 Forbidden');
    header("Location: index.php");
    die();
    
}
?>

<!DOCTYPE html>
<html lang="pt-BR" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel | IPTV SERVER</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/painel.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/defaults-pt_BR.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/painel.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/editor.css">
    <link href="css/all.css" rel="stylesheet">
    <link rel="icon" href="img/logo.png">
    <style>
      .pesquisar {
          max-width: 200px;
      }

      #conteudo tr[visible='false'], .semresultado{
          display: none;
      }

      #conteudo tr[visible='true']{
          display:table-row;
      }

      #conteudoQ td, th {
          overflow: hidden;
          text-overflow: clip;
      }
      
      table th, table td { 
        overflow: hidden; 
        max-width:100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      #conteudoQ tr[visible='false']{
          display: none;
      }

      #conteudoQ tr[visible='true']{
          display:table-row;
      }
    </style>

</head>

<body>
<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a>Painel</a>
            <div id="close-sidebar">
            <i class="fas fa-times"></i>
            </div>
        </div>
        <!--user-->
        <div class="sidebar-header">
          <div class="user-pic">
            <img class="img-responsive img-rounded" src="img/user.jpg"
              alt="User picture">
          </div>
          <div class="user-info">
            <span class="user-name">
              <?= usuarioLogado()?>
            </span>
            <span class="user-status">
              <i class="fa fa-circle"></i>
              <span>Online</span>
            </span>
          </div>
      </div>
      <!-- USER-->
      <div class="sidebar-menu">
        <ul>
          <li id="lista.php">
            <a href="lista.php">
              <i class="fas fa-list-ul"></i>
              <span>Listas</span>
            </a>
          </li>
          <li id="link.php">
            <a href="link.php">
              <i class="fas fa-link"></i>
              <span>Links</span>
            </a>
          </li>
          <li id="categoria.php">
            <a href="categoria.php">
              <i class="fas fa-list-alt"></i>
              <span>Categorias</span>
            </a>
          </li>
          <li id="usuario.php">
            <a href="usuario.php">
              <i class="fas fa-users"></i>
              <span>Usuários</span>
            </a>
          </li>
          
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="sair.php">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </nav>
  <!-- sidebar-wrapper  -->

  <script>
    if (location.pathname.includes("<?= $paginaCorrente = basename($_SERVER['SCRIPT_NAME']);?>")) {
      document.getElementById('<?= $paginaCorrente = basename($_SERVER['SCRIPT_NAME']);?>').classList.add("ativado");
    }
  </script>
  <main class="page-content">
    <div class="container-fluid">