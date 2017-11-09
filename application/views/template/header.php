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
                    <menu-item v-for="item in menuItens" v-bind:item="item" v-bind:key="item.id"></menu-item>
                </ul>
            </div>
            <div class="col-md-10">