<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titulo ?></title>
    
    <!-- Fav -->
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/PPocket-branco.png" type="image/x-icon"> 
    <link rel="icon" href="<?= base_url(); ?>assets/img/PPocket-branco.png" type="image/x-icon"> 
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/normalize.min.css" type="text/css" />
    
    <?php
		if($this->uri->uri_string() == 'login') { ?>
			<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/style/login.min.css">
	<?php } else { 	?>
			<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/style/painel.min.css">
	<?php };	?>

</head>
<body>
    <div id="painel" class="painel">
        <!-- BASE DO PAINEL -->
        <header class="painel-header">
            <div class="container-fluid">
                <div class="painel-header_wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="logo-ppocket"> 
                                <!-- <h1 class="disable"> PPocket </h1>  -->
                                <img src="<?= base_url(); ?>assets/img/PPocket-branco.png" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col">
                            <p class="text-right msg-usuario"> 
                                <i class="fa fa-user"></i> Bem-vindo <?= $this->session->userdata('nm_funcionario'); ?> &nbsp;&nbsp;&nbsp;&nbsp; 
                                <a href="<?= base_url(); ?>/login/">
                                    <i class="fa fa-sign-out"></i> Sair</a>
                            </p>
                            <!-- <p class="text-right msg-usuario"> <i class="fa fa-user"></i> Sair </p> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="painel-sidebar">
            <nav class="painel-sidebar_nav">
                <h2> <i class="fa fa-bars"></i> Menu </h2>
                <ul class="list-unstyled painel-sidebar_nav__ul">
                    <?php if ($this->session->userdata('cd_permissao') == 3 || $this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>projetos"><li><i class="fa fa-files-o"></i> Projetos</li></a>
                    <?php } ?>
                    <?php if ($this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>cargos"><li><i class="fa fa-user-o"></i> Cargos</li></a>
                    <?php } ?>
                    <?php if ($this->session->userdata('cd_permissao') == 3 || $this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>clientes"><li><i class="fa fa-address-card-o"></i> Clientes</li></a>
                    <?php } ?>
                    <?php if ($this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>servicos"><li><i class="fa fa-handshake-o"></i> Serviços</li></a>
                    <?php } ?>
                    <?php if ($this->session->userdata('cd_permissao') == 4 || $this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>funcionarios"><li><i class="fa fa-address-card-o"></i> Funcionários</li></a>
                    <?php } ?>
                    <?php if ($this->session->userdata('cd_permissao') == 1 || 
                                $this->session->userdata('cd_permissao') == 2 || $this->session->userdata('cd_permissao') == 5){ ?>
                        <a href="<?= base_url(); ?>tarefas"><li><i class="fa fa-file-archive-o"></i> Tarefa</li></a>
                    <?php } ?>
                
                    
                </ul>
            </nav>
        </div>

        <div class="painel-main">
                
            <!-- Alert de Sucesso -->
            <div id="alert-msg" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none; position: fixed; background: #28a745!important; top: 10px; left: 35%; width: 35%; height: 50px;">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <p></p>
            </div>
