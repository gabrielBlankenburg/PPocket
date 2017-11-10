<?php $query; ?>
<form class="offset-md-1 col-md-10" id="editar">
    <input type="hidden" name="cd_cargo" value="<?= $cargo->getChavePrimariaValor(); ?>"/>
    <div class="form-group">
        <label for="nm_cargo">Nome do Cargo</label>
        <input type="text" class="form-control" id="nm_cargo" name="nm_cargo" value="<?= $cargo->getNomeCargo(); ?>" placeholder="Nome do cargo">
    </div>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal">Remover Cargo</button>
    <button type="submit" class="btn btn-primary offset-sm-7">Atualizar Cargo</button>
</form>

<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tem certeza?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Isso irá remover o cargo definitivamente!</p>
        </div>
        <div class="modal-footer justify-content-start">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="remover" data-dismiss="modal">Remover</button>
        </div>
    </div>

  </div>
</div>