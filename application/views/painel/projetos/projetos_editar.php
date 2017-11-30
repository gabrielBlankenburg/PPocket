<?php $query; ?>
<div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Editar</small> <br> <strong>Projeto</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>projetos" class="btn btn-default btn-principal float-right">Voltar para projetos</a>
            </div>
        </div>
    </div>
    <div class="row">
        <form class="pp-form col-6" id="editar">
            <input type="hidden" name="cd_projeto" value="<?= $projeto->getChavePrimariaValor(); ?>"/>
            <div class="form-group">
                <label for="nm_projeto">Projeto</label> 
                <input type="text" class="pp-form_input__text form-control" id="nm_projeto" name="nm_projeto" value="<?= $projeto->getNomeProjeto(); ?>" placeholder="Nome do projeto">
                <label for="dt_inicio">Data de início</label>
                <input type="date" class="pp-form_input__text form-control" id="dt_inicio" name="dt_inicio" value="<?= $projeto->getDataInicio(); ?>" placeholder="dd/mm/aaaa">           
                <label for="dt_termino">Data de término</label>
                <input type="date" class="pp-form_input__text form-control" id="dt_termino" name="dt_termino" value="<?= $projeto->getDataTermino(); ?>" placeholder="dd/mm/aaaa">
                <label for="ds_projeto">Descrição</label>
                <textarea class="pp-form_input__text form-control" id="ds_projeto" name="ds_projeto"><?= $projeto->getDescricaoProjeto(); ?></textarea>
                <label for="cd_cliente">Cliente</label>
                <select class="pp-form_input__text form-control" name="cd_cliente" id="cd_cliente">
                    <option>Escolha uma opção</option>
                    <?php foreach ($clientes as $cliente){ ?>
                        <option value="<?= $cliente['cd_cliente']; ?>" <?= $cliente['cd_cliente'] == $projeto->getChaveCliente() ? 'selected' : '' ?>><?= $cliente['nm_cliente']; ?></option>
                    <?php } ?>
                </select>    
                <div class="multiple-inputs">
                    <label>Serviços</label>
                    <?php foreach ($projeto->getServicos() as $projeto_servico) { ?>
                        <select class="pp-form_input__text form-control multiple-input" name="cd_servico[]" id="cd_servico[]">
                            <option>Escolha uma opção</option>
                            <?php foreach ($servicos as $servico) { ?>
                                <option value="<?= $servico['cd_servico'] ?>" 
                                    <?= $servico['cd_servico'] == $projeto_servico->getChavePrimariaValor() ? 'selected'
                                    : '' ?>>
                                        <?= $servico['nm_servico'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
                <br>
                <div class="row">
                    <p class="d-block mx-auto text-danger remove-multiple-input"><i class="fa fa-close"></i> Remover serviço</p>
                </div>
                <div class="row">
                    <p class="d-block mx-auto text-primary add-multiple-input"><i class="fa fa-plus"></i> Adcionar serviço</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-default btn-outline-danger modal-btn_close float-left" data-toggle="modal" data-target="#modal">Remover Projeto</button>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-default btn-outline-success float-right">Atualizar Projeto</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
    
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