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
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/style/login.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-design-blocks/2.0.1/css/froala_blocks.min.css" type="text/css" />    


</head>
<body>
	<section class="fdb-block py-0">
  <div class="container py-5 my-5" style="background-image: url(https://cdn.jsdelivr.net/gh/froala/design-blocks@2.0.1/dist/imgs/shapes/4.svg);">
    <div class=" row justify-content-end">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5 text-left">
        <div class="fdb-box">
          <div class="row">
          		<?php
						if (!empty($this->session->flashdata('autenticacao'))){
							echo $this->session->flashdata('autenticacao');
						}
					?>
            <div class="col">
              <h1><img src="/assets/img/PPocket.png" class="img-responsive" style="width: 30px"></img>ocket</h1>
              <p class="lead">Bem vindo a sua nova ferramenta para organização de pequenos projetos.</p>
            </div>
          </div>
         <form action="<?= base_url().'login/autenticar'; ?>" method="POST" class="">

          <div class="row">
            <div class="col mt-4">
            	
									<input type="text" name="email" class="form-control" placeholder="Digite seu login..." required autofocus>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col">
									<input type="password" name="senha" class="form-control" placeholder="Digite sua senha..." required>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col">
								<input type="submit" class="btn btn-secondary" value="Entrar	">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>