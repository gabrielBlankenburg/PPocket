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


</head>
<body>
	<div class="login">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 280.17 243.1">
			<circle cx="168.1" cy="112.07" r="112.07" style="fill:#2a2a2a"/>
		</svg>
		<div class="container">
			<div class="row">
				<div class="login-wrapper">
					<?php
						if (!empty($this->session->flashdata('autenticacao'))){
							echo $this->session->flashdata('autenticacao');
						}
					?>
					<div class="row">
						<div class="login-wrapper_titulo">
							<p><small>Bem-vindo ao</small></p>
							<h1 class="login-titulo">PPocket</h1>
						</div>
					</div>
					<div class="row">
						<div class="login-wrapper_form">
							<form action="<?= base_url().'login/autenticar'; ?>" method="POST" class="form form-group login-form">
								<label for="login" class="login-form_label">
									<input type="text" name="email" class="form-control login-form_input__text" placeholder="Digite seu login..." required autofocus>
								</label>
								<label for="senha" class="login-form_label">
									<input type="password" name="senha" class="form-control login-form_input__text" placeholder="Digite sua senha..." required>
								</label>
								<p class="login-form_p text-center">
									<small>Não consegue entrar? <span>Resgatar acesso.</span></small>
								</p>
								<input type="submit" class="btn btn-default login-form_input__submit" value="Entrar	">
							</form> <!-- Form -->
						</div> <!-- Login Wrapper Form-->
					</div>
				</div> <!-- Login Wrapper -->
			</div>
		</div>
		<!-- <div class="copyright">Desenvolvido por ApolloUX</div> -->
	</div> <!-- Login -->
	<!-- Fim Login -->