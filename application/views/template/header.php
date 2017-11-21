<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titulo ?></title>
    <!-- Estilos -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/normalize.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/painel.min.css" type="text/css" />

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                                <i class="fa fa-user"></i> Bem-vindo Marquinhos &nbsp;&nbsp;&nbsp;&nbsp; 
                                <a href="<?= base_url(); ?>index.php/login/">
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
                    <a href="<?= base_url(); ?>projetos"><li>Projetos</li></a>
                    <a href="<?= base_url(); ?>cargos"><li>Cargos</li></a>
                    <a href="<?= base_url(); ?>clientes"><li>Clientes</li></a>
                    <a href="<?= base_url(); ?>servicos"><li>Serviços</li></a>
                    <a href="<?= base_url(); ?>funcionarios"><li>Funcionários</li></a>
                    <a href="<?= base_url(); ?>tarefas"><li>Tarefa</li></a>
                </ul>
            </nav>
        </div>

        <div class="painel-main">