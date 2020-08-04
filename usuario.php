<?php
session_start();
require_once("controles/usuarios.php");
require_once("controles/listas.php");
if (checarUsuario()) {
require_once("cabecalho.php");
$usuarios = listarUsuarios();
$listas = listarListas();
?>
        <div id="conteudo-painel" class="container">
<?php if ($usuarios) { ?>
                <div class="mb-5 form-group float-left">
                    <input type="text" class="pesquisar form-control" placeholder="Pesquisar...">
                </div>  
                <table class='table table-bordered table-hover'>
                    <caption>Usuários</caption>
                    <thead class="thead-light">
                        <tr>
                            <th class='nomecol' scope="col" >Nome</th>
                            <th class='nomecol' scope="col" >Login</th>
                            <th class='nomecol' scope="col" >Estado</th>
                            <th class='nomecol' scope="col" >Administrador</th>
                            <th class='nomecol' scope="col" >Contato</th>
                            <th class='nomecol' scope="col" >Listas</th>
                            <th class='nomecol' scope="col"></th>
                            <th class='nomecol' scope="col"></th>
                            <th class='semresultado' scope='col'>Nenhum resultado</th>
                        </tr>
                    </thead>
                <tbody id="conteudo">
<?php foreach($usuarios as $usuario) { ?>
                        <tr>
                            <td > <?=$usuario['nome_usuario']?> </td>
                            <td> <?=$usuario['login_usuario']?> </td>
                            <td> 
                                <?php if ($usuario['estado_usuario'] == 1) {echo "Ativo";} else {echo "Desativado";} ?> 
                            </td>
                            <td> 
                                <?php if ($usuario['admin'] == 1) {echo "Sim";} else {echo "Não";} ?> 
                            </td>
                            <td> 
                                <?=$usuario['contato_usuario']?> 
                            </td>
                            <td> 
                                <?php foreach (listasUsuario($usuario["id_usuario"]) as $lista) echo '[' . $lista['nome_lista'] . '] '; ?> 
                            </td>
                            <td>
                                <button class='btn btn-outline-danger' onclick="removerConfirma('<?=$usuario['id_usuario']?>', '<?=$usuario['nome_usuario']?>')">Remover</button>
                            </td>
                            <td>
                                <button class='btn btn-outline-secondary' onclick="editarConfirma('<?=$usuario['id_usuario']?>','<?=$usuario['nome_usuario']?>','<?=$usuario['contato_usuario']?>','<?=$usuario['login_usuario']?>','<?=$usuario['estado_usuario']?>','<?=$usuario['admin']?>', [<?php foreach (listasUsuario($usuario['id_usuario']) as $lista) echo $lista['id_lista'] .',' ?> ])">Editar</button>
                            </td>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
        <?php
        }
        ?>
            <div class="h3 mt-5 row align-items-center justify-content-center">
                <i onclick="$('#cadastro').modal()" class="btn btn-outline-info text-dark fas fa-plus"></i>
            </div>
        </div>
    </div>

  </main>
  <!-- page-content" -->
</div>
<!-- Cadastro Inicio -->
<div class="modal fade" id="cadastro" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalLongoExemplo">Adicionar Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="cadastro-form">
            <div class="container">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Nome do usuário" required autofocus>
                </div>
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" class="form-control" name="login" placeholder="Identificação do usuário" required>
                    <small class="form-text text-muted">Único para cada usuário!</small>
                </div>
                <div id="sC">
                    <div id="divSenhaC" class="form-group">
                        <label>Senha:</label>
                        <input type="password" class="form-control" name="senha" placeholder="Senha do usuário" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Contato:</label>
                    <input type="text" class="form-control" name="contato" placeholder="Contato do usuário">
                </div>
                <div class="form-group">
                    <label>Administrador:</label>
                    <div class="ml-0 row">
                        <select id="adminC" class="selectpicker" title="Administrador..." name="admin" required>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Listas:</label>
                    <div class="ml-0 row">
                        <select name="lista[]" class="selectpicker" title="Listas..." multiple>
                <?php if ($listas) { 
                    foreach ($listas as $lista) {?>
                        <option value="<?=$lista['id_lista']?>"><?=$lista['nome_lista']?></option>
                    <?php  } 
                    } ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Cadastro Fim-->
<!-- Remove Inicio -->
<div class="modal fade" id="remover" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tem certeza?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="remover-conteudo" class="modal-body"></div>
    </div>
  </div>
</div>
<!-- Remove Fim-->
<!-- Edita Inicio -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="Cadastrar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editar-form">
            <div class="container">
                <input type="hidden" id="idE" name="id">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" class="form-control" id="nomeE" name="nome" placeholder="Nome do usuário" required autofocus>
                </div>
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" class="form-control" id="loginE" name="login" placeholder="Identificação do usuário" required>
                    <small class="form-text text-muted">Único para cada usuário!</small>
                </div>
                <div id="s">
                    <div id="divSenha" class="form-group">
                        <label>Senha:</label>
                        <input type="password" class="form-control" id="senhaE" name="senha" placeholder="Senha do usuário">
                        <small class="form-text text-muted">Deixa em branco se não quer trocar!</small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Contato:</label>
                    <input type="text" class="form-control" id="contatoE" name="contato" placeholder="Contato do usuário">
                </div>
                <div class="form-group">
                    <label>Estado:</label>
                    <div class="ml-0 row">
                        <select id="estadoE" class="selectpicker" title="Estado..." name="estado">
                            <option value="1">Ativo</option>
                            <option value="0">Desativado</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Administrador:</label>
                    <div class="ml-0 row">
                        <select id="adminE" class="selectpicker" title="Administrador..." name="admin">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Listas:</label>
                    <div class="ml-0 row">
                        <select id="listaE" name="lista[]" class="selectpicker" title="Listas..." multiple>
                <?php if ($listas) { 
                    foreach ($listas as $lista) {?>
                        <option value="<?=$lista['id_lista']?>"><?=$lista['nome_lista']?></option>
                    <?php  } 
                    } ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Edita Fim-->
</body>
<script>
    var clone = $("#divSenha").clone();
    var cloneC = $("#divSenhaC").clone();
    $("#divSenhaC").remove();

    $("#cadastro").on('hidden.bs.modal', function (e) {
        if ($( "#adminC" ).val() != 1) {
            $("#sC").empty();
        }
    });

    $( "#adminC" ).change(function() {
        if ($( "#adminC" ).val() == 1) {
            $("#sC").append(cloneC);
        } else {
            $("#sC").empty();
        }
    });

    function removerConfirma(id,nome) {
        $('#remover-conteudo').html('<div class="alert alert-danger" role="alert"><strong> Remover </strong>' + nome + '?</div><button onclick="remover(' + id + ')" type="submit" class="btn btn-danger float-right">Remover</button>');
        $('#remover').modal();
    }

    function editarConfirma(id,nome,contato,login,estado,admin, lista) {
        $('#idE').val(id);
        $('#nomeE').val(nome);
        $('#contatoE').val(contato);
        $('#loginE').val(login);
        $('#estadoE').val(estado);
        $('#estadoE').selectpicker('render');
        $('#adminE').val(admin);
        $('#adminE').selectpicker('render');
        if (admin == 0) {
            $('#divSenha').remove();
        } else if ($('#divSenha').length < 1) {
            $('#s').append(clone);
        }
        $('#listaE').val(lista);
        $('#listaE').selectpicker('render');
        $('#editar').modal();
    }

    function remover(id) {
        $.ajax({
            type: "POST",
            url: "controles/remover-usuario.php",
            data: {usuario: id},
            success: function(data) {
                location.reload();
            }
        });
    }

    $( "#cadastro-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/adicionar-usuario.php",
            data: $("#cadastro-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });

    $( "#editar-form" ).submit(function( event ) {
        $.ajax({
            type: "POST",
            url: "controles/editar-usuario.php",
            data: $("#editar-form").serialize(),
            success: function(data) {
                location.reload();
            },
            error: function(data) {
              resultado(data.responseText);
            }
        });
        event.preventDefault();
    });

</script>
<?php require_once("comum.php"); 
require_once("alerta.php");?>

</html>
<?php 
} else {
    header("Location: index.php");
    die();
}
?>