<?php $query; ?>
<template>
    <div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Editar</small> <br> <strong>Serviço</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>servicos" class="btn btn-default btn-principal float-right">Voltar para lista</a>
            </div>
        </div>
    </div>
    <div class="row">
        <form class="pp-form col-md-8" id="editar">
            <input type="hidden" name="cd_servico" value="<?= $servico->getChavePrimariaValor(); ?>"/>
            <div class="form-group">
                <label class="pp-form_label" for="nm_servico">Nome do Serviço</label>
                <input type="text" class="pp-form_input__text form-control" id="nm_servico" name="nm_servico" value="<?= $servico->getNomeServico(); ?>" placeholder="Nome do serviço">
                <label class="pp-form_label" for="ds_servico">Descrição do Serviço</label>
                <textarea class="pp-form_input__text form-control" id="ds_servico" name="ds_servico" placeholder="Descrição do serviço"><?= $servico->getDescricaoServico(); ?></textarea>
                <label class="pp-form_label" for="vl_servico">Nome do Serviço</label>
                <input type="number" class="pp-form_input__text form-control" id="vl_servico" name="vl_servico" value="<?= $servico->getValorServico(); ?>" placeholder="Valor estimado do serviço">
                <label class="pp-form_label" for="cd_cargo">Cargo</label>
                <select class="pp-form_input__text form-control" name="cd_cargo" id="cd_cargo">
                    <option>Escolha uma opção</option>
                    <?php foreach ($cargos as $cargo){ ?>
                        <option value="<?= $cargo['cd_cargo']; ?>" <?= $cargo['cd_cargo'] == $servico->getChaveCargo() ? 'selected' : '' ?>><?= $cargo['nm_cargo']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="button" class="btn btn-outline-danger float-left" data-toggle="modal" data-target="#modal">Remover Serviço</button>
            <button type="submit" class="btn btn-outline-success float-right">Atualizar Serviço</button>
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