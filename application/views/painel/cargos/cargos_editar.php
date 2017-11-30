<?php $query; ?>
<div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Editar</small> <br> <strong>Cargo</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>cargos" class="btn btn-default btn-principal float-right">Voltar para lista</a>
            </div>
        </div>
    </div>
    <div class="row">
        <form class="pp-form col-6" id="editar">
            <input type="hidden" name="cd_cargo" value="<?= $cargo->getChavePrimariaValor(); ?>"/>
            <div class="form-group">
                <label for="nm_cargo">Nome do Cargo</label>
                <input type="text" class="pp-form_input__text form-control" id="nm_cargo" name="nm_cargo" value="<?= $cargo->getNomeCargo(); ?>" placeholder="Nome do cargo">
            </div>
            <button type="button" class="btn btn-outline-danger float-left" data-toggle="modal" data-target="#modal">Remover Cargo</button>
        <button type="submit" class="btn btn-outline-success float-right">Atualizar Cargo</button>
        </form>
    </div>
</div>

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