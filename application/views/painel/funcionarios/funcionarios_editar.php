<?php $query; ?>
<form class="offset-md-1 col-md-10" id="editar">
    <input type="hidden" name="cd_funcionario" value="<?= $funcionario->getChavePrimariaValor(); ?>"/>
    <div class="form-group">
        <label for="nm_cargo">Nome</label>
        <input type="text" class="form-control" id="nm_cargo" name="nm_funcionario" value="<?= $funcionario->getNomeFuncionario(); ?>" placeholder="Nome do funcionário">
    </div>
    <div class="form-group">
        <label for="cd_cargo">Cargo</label>
        <select class="form-control" name="cd_cargo" id="cd_cargo">
            <?php foreach ($cargos as $cargo) { ?>
                    <option value="<?= $cargo['cd_cargo'] ?>" <?= $cargo['cd_cargo'] == $funcionario->getChaveCargo() ? 'selected' : '' ?>>
                        <?= $cargo['nm_cargo'] ?>
                    </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="vl_salario">Salário</label>
        <input type="number" class="form-control" id="vl_salario" name="vl_salario" value="<?= $funcionario->getSalarioFuncionario(); ?>" placeholder="Salário do funcionário">
    </div>
    <div class="form-group">
        <label for="ds_email">Email</label>
        <input type="email" class="form-control" id="ds_email" name="ds_email" value="<?= $funcionario->getEmailFuncionario(); ?>" placeholder="funcionario@empresa.com">
    </div>
    <div class="form-group">
        <label for="cd_telefone">Telefone</label>
        <input type="number" class="form-control" id="cd_telefone" name="cd_telefone" value="<?= $funcionario->getTelefoneFuncionario(); ?>" placeholder="Telefone do Funcionário">
    </div>
    <div class="form-group">
        <label for="cd_celular">Celular</label>
        <input type="number" class="form-control" id="cd_celular" name="cd_celular" value="<?= $funcionario->getCelularFuncionario(); ?>" placeholder="Celular do Funcionário">
    </div>
    <div class="form-group">
        <label for="dt_nascimento">Data de nascimento</label>
        <input type="text" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?= $funcionario->getNascimentoFuncionario(); ?>" placeholder="Data de Nascimento do Funcionário">
    </div>
    <div class="form-group">
        <label for="cd_rg">RG</label>
        <input type="number" class="form-control" id="cd_rg" name="cd_rg" value="<?= $funcionario->getRgFuncionario(); ?>" placeholder="RG">
    </div>
    <div class="form-group">
        <label for="cd_cpf">CPF</label>
        <input type="number" class="form-control" id="cd_cpf" name="cd_cpf" value="<?= $funcionario->getCpfFuncionario(); ?>" placeholder="CPF">
    </div>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal">Remover Funcionario</button>
    <button type="submit" class="btn btn-primary offset-sm-7">Atualizar Funcionario</button>
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
            <p>Isso irá remover o funcionário definitivamente!</p>
        </div>
        <div class="modal-footer justify-content-start">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="remover" data-dismiss="modal">Remover</button>
        </div>
    </div>

  </div>
</div>