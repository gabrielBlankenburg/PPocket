<?php $query; ?>
<template>
<div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Editar</small> <br> <strong>Clientes</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>clientes" class="btn btn-default btn-principal float-right">Voltar para lista</a>
            </div>
        </div>
    </div>
    <div class="row">
    <form class="pp-form col-8" id="editar">
        <input type="hidden" name="cd_cliente" value="<?= $cliente->getChavePrimariaValor(); ?>"/>
        <div class="row">
            <div class="col">
                 <div class="form-group">
                    <label class="pp-form_label" for="nm_cliente">Nome do cliente</label>
                    <input type="text" class="pp-form_input__text form-control" id="nm_cliente" name="nm_cliente" value="<?= $cliente->getNomeCliente(); ?>" placeholder="Nome da empresa do cliente">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_cnpj">CNPJ</label>
                    <input type="text" class="pp-form_input__text form-control cnpj" id="cd_cnpj" name="cd_cnpj" value="<?= $cliente->getCnpj(); ?>" placeholder="CNPJ">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_cpf">CPF</label>
                    <input type="text" class="pp-form_input__text form-control cpf" id="cd_cpf" name="cd_cpf" value="<?= $cliente->getCpf(); ?>" placeholder="CPF">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="ds_email">Email</label>
                    <input type="email" class="pp-form_input__text form-control" id="ds_email" name="ds_email" value="<?= $cliente->getEmail(); ?>" placeholder="exemplo@email.com">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_telefone">Telefone</label>
                    <input type="text" class="pp-form_input__text form-control phone_with_ddd" id="cd_telefone" name="cd_telefone" value="<?= $cliente->getTelefone(); ?>" placeholder="Telefone do cliente">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="pp-form_label" for="nm_responsavel">Nome do Responsável</label>
                    <input type="text" class="pp-form_input__text form-control" id="nm_responsavel" name="nm_responsavel" value="<?= $cliente->getNomeResponsavel(); ?>" placeholder="Nome do cliente">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="ds_responsavel_email">Email do Responsável</label>
                    <input type="email" class="pp-form_input__text form-control" id="ds_responsavel_email" name="ds_responsavel_email" value="<?= $cliente->getEmailResponsavel(); ?>" placeholder="exemplo@email.com">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_responsavel_telefone">Telefone do Responsável</label>
                    <input type="text" class="pp-form_input__text form-control phone_with_ddd" id="cd_responsavel_telefone" name="cd_responsavel_telefone" value="<?= $cliente->getTelefoneResponsavel(); ?>" placeholder="Telefone do cliente">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-outline-danger float-left" data-toggle="modal" data-target="#modal">Remover Cliente</button>
        <button type="submit" class="btn btn-outline-success float-right">Atualizar Cliente</button>
    </form>
</div>
</template>
<!-- Modal -->
<div id="modal" class="modal-ppocket" role="dialog">
  <div class="modal-wrapper">
    <div class="modal-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h2 class="h3"><small>Tem</small> <br> <strong>Certeza?</strong></h2>
                </div>
                <div class="col">
                    <p class="float-right modal-close modal-btn_close" data-dismiss="modal"><i class="fa fa-close"></i></p>
                </div>
            </div>
        </div>
    </div>
   <!--  <div class="modal-body">
        <p>Isso irá remover o cliente definitivamente!</p>
    </div> -->
    <div class="modal-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-outline-warning float-left" data-dismiss="modal">Cancelar</button>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-danger float-right" id="remover" data-dismiss="modal">Remover</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>