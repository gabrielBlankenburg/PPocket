<?php $query; ?>
<div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Editar</small> <br> <strong>Funcionário</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>funcionarios" class="btn btn-default btn-principal float-right">Voltar para lista</a>
            </div>
        </div>
    </div>
    <div class="row">
        <form class="pp-form col-8" id="editar">
            <input type="hidden" name="cd_funcionario" value="<?= $funcionario->getChavePrimariaValorFilho(); ?>"/>
            <div class="form-group">
                <label for="nm_cargo">Nome</label>
                <input type="text" class="pp-form_input__text form-control" id="nm_cargo" name="nm_funcionario" value="<?= $funcionario->getNomeFuncionario(); ?>" placeholder="Nome do funcionário">
            </div>
            <div class="form-group">
                <label for="cd_cargo">Cargo</label>
                <select class="pp-form_input__text form-control" name="cd_cargo" id="cd_cargo">
                    <?php foreach ($cargos as $cargo) { ?>
                            <option value="<?= $cargo['cd_cargo'] ?>" <?= $cargo['cd_cargo'] == $funcionario->getChaveCargo() ? 'selected' : '' ?>>
                                <?= $cargo['nm_cargo'] ?>
                            </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="cd_permissao">Permissões</label>
                <select class="pp-form_input__text form-control" name="cd_permissao" id="cd_permissao">
                    <option>Selecione</option>
                    <option value="1" <?php echo $funcionario->getPermissao() == 1 ? 'selected' : '' ?>>Ver tarefas</option>
                    <option value="2" <?php echo $funcionario->getPermissao() == 2 ? 'selected' : '' ?>>Ver e abrir tarefas</option>
                    <option value="3" <?php echo $funcionario->getPermissao() == 3 ? 'selected' : '' ?>>Ver e editar projetos e clientes</option>
                    <option value="4" <?php echo $funcionario->getPermissao() == 4 ? 'selected' : '' ?>>Ver e editar funcionários</option>
                    <option value="5" <?php echo $funcionario->getPermissao() == 5 ? 'selected' : '' ?>>Permissão total</option>
                </select>
            </div>
            <div class="form-group">
                <label for="vl_salario">Salário</label>
                <input type="text" class="pp-form_input__text form-control money" id="vl_salario" name="vl_salario" value="<?= $funcionario->getSalarioFuncionario(); ?>" placeholder="Salário do funcionário">
            </div>
            <div class="form-group">
                <label for="ds_email">Email</label>
                <input type="email" class="pp-form_input__text form-control" id="ds_email" name="ds_email" value="<?= $funcionario->getEmailFuncionario(); ?>" placeholder="funcionario@empresa.com">
            </div>
            <div class="form-group">
                <label for="ds_email_corporacional">Email Corporacional</label>
                <input type="email" class="pp-form_input__text form-control" id="ds_email_corporacional" name="ds_email_corporacional" value="<?= $funcionario->getEmailUsuario(); ?>" placeholder="funcionario@empresa.com">
            </div>
            <div class="form-group">
                <label for="cd_telefone">Telefone</label>
                <input type="text" class="pp-form_input__text form-control phone_with_ddd" id="cd_telefone" name="cd_telefone" value="<?= $funcionario->getTelefoneFuncionario(); ?>" placeholder="Telefone do Funcionário">
            </div>
            <div class="form-group">
                <label for="cd_celular">Celular</label>
                <input type="text" class="pp-form_input__text form-control phone_with_ddd" id="cd_celular" name="cd_celular" value="<?= $funcionario->getCelularFuncionario(); ?>" placeholder="Celular do Funcionário">
            </div>
            <div class="form-group">
                <label for="dt_nascimento">Data de nascimento</label>
                <input type="text" class="pp-form_input__text form-control" id="dt_nascimento" name="dt_nascimento" value="<?= $funcionario->getNascimentoFuncionario(); ?>" placeholder="Data de Nascimento do Funcionário">
            </div>
            <div class="form-group">
                <label for="cd_rg">RG</label>
                <input type="text" class="pp-form_input__text form-control rg" id="cd_rg" name="cd_rg" value="<?= $funcionario->getRgFuncionario(); ?>" placeholder="RG">
            </div>
            <div class="form-group">
                <label for="cd_cpf">CPF</label>
                <input type="text" class="pp-form_input__text form-control cpf" id="cd_cpf" name="cd_cpf" value="<?= $funcionario->getCpfFuncionario(); ?>" placeholder="CPF">
            </div>
            <input type="hidden" name="ic_primeiro_acesso" value="<?= $funcionario->getPrimeiroAcesso(); ?>" />
            <input type="hidden" name="cd_usuario" value="<?= $funcionario->getChavePrimariaValor(); ?>" />
            <input type="hidden" name="ds_hash" value="<?= $funcionario->getHash(); ?>" />
            <button type="button" class="btn btn-outline-danger float-left" data-toggle="modal" data-target="#modal">Remover Funcionário</button>
            <button type="submit" class="btn btn-outline-success float-right">Atualizar Funcionário</button>
    
        </form>
    </div>
        
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