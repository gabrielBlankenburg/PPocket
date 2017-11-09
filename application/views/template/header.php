<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titulo ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/style/main.css" type="text/css" />
</head>
<body>
    <div id="painel" class="container-fluid">
        <div class="row">
            <div id="menu" class="col-md-2">
                <ul class="list-group">
                    <a href="<?= base_url(); ?>projetos"><li class="list-group-item">Projetos</li></a>
                    <a href="<?= base_url(); ?>cargos"><li class="list-group-item">Cargos</li></a>
                    <a href="<?= base_url(); ?>clientes"><li class="list-group-item">Clientes</li></a>
                    <a href="<?= base_url(); ?>serviços"><li class="list-group-item">Serviços</li></a>
                    <a href="<?= base_url(); ?>funcionarios"><li class="list-group-item">Funcionários</li></a>
                    <a href="<?= base_url(); ?>tarefas"><li class="list-group-item">Tarefa</li></a>
                </ul>
            </div>
            <div class="col-md-10">