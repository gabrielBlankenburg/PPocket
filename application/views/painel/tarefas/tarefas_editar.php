<?php $query; ?>
    <div class="container general">
        <div class="row">
            <div class="col-6">
                <h3> <small>Editar</small> <br> <strong>Tarefa</strong> </h3>
                <hr>
            </div>  
            <div class="col-6">
                <div class="projetos-novo_wrapper__btn">
                    <a href="<?= base_url(); ?>tarefas" class="btn btn-default btn-principal float-right">Voltar para lista</a>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="pp-form col-md-8" id="editar">
            <input type="hidden" name="cd_tarefa" value="<?= $tarefa->getChavePrimariaValor(); ?>"/>
            <div class="form-group">
                <label class="pp-form_label" for="nm_tarefa">Tarefa</label> 
                <input type="text" class="pp-form_input__text form-control" id="nm_tarefa" name="nm_tarefa" value="<?= $tarefa->getNomeTarefa(); ?>" placeholder="Nome da tarefa">
                <label class="pp-form_label" for="ds_tarefa">Descrição</label>
                <textarea class="pp-form_input__text form-control" id="ds_tarefa" name="ds_tarefa"><?= $tarefa->getDescricaoTarefa(); ?></textarea>
                <label class="pp-form_label" for="ic_concluido">Status</label>
                <select class="pp-form_input__text form-control" name="ic_concluido" id="ic_concluido">
                    <option>Escolha uma opcao</option>
                    <option value="0" <?= $tarefa->getConcluido() == 0 ? 'selected' : '' ?>>Aberta</option>
                    <option value="1" <?= $tarefa->getConcluido() == 1 ? 'selected' : '' ?>>Concluída</option>
                </select>
                <label class="pp-form_label" for="cd_projeto">Projeto</label>
                <select class="pp-form_input__text form-control" name="cd_projeto" id="cd_projeto">
                    <option>Escolha uma opção</option>
                    <?php foreach ($projetos as $projeto){ ?>
                        <option value="<?= $projeto['cd_projeto']; ?>" <?= $projeto['cd_projeto'] == $tarefa->getChaveProjeto() ? 'selected' : '' ?>><?= $projeto['nm_projeto']; ?></option>
                    <?php } ?>
                </select>    
                <div class="form-group">
                    <label class="pp-form_label" class="pp-form_label" for="cd_servico">Serviço</label>
                    <select class="pp-form_input__text form-control" id="cd_servico" name="cd_servico">
                        <option value="0" selected>Escolha um serviço</option>
                        <?php foreach ($servicos as $servico) { ?>
                            <option value="<?= $servico['cd_servico'] ?>" <?= $servico['cd_servico'] == $tarefa->getChaveServico() ? 'selected' : '' ?>>
                                <?= $servico['nm_servico'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="pp-form_label" class="pp-form_label" for="cd_funcionario">Funcionário</label>
                    <select class="pp-form_input__text pp-form_input__text form-control" id="cd_funcionario" name="cd_funcionario">
                        <option value="0" selected>Escolha um funcionário</option>
                        <?php foreach ($funcionarios as $funcionario) { ?>
                            <option value="<?= $funcionario['cd_funcionario'] ?>" <?= $funcionario['cd_funcionario'] == $tarefa->getChaveFuncionario() ? 'selected' : '' ?>>
                                <?= $funcionario['nm_funcionario'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                
                <input type="hidden" name="cd_permissao" value="<?= $tarefa->getFuncionario()->getPermissao(); ?>" />
                <input type="hidden" name="ic_primeiro_acesso" value="<?= $tarefa->getFuncionario()->getPrimeiroAcesso(); ?>" />
                <input type="hidden" name="cd_usuario" value="<?= $tarefa->getFuncionario()->getChavePrimariaValor(); ?>" />
                <input type="hidden" name="ds_hash" value="<?= $tarefa->getFuncionario()->getHash(); ?>" />
                <input type="hidden" name="ds_email_corporacional" value="<?= $tarefa->getFuncionario()->getEmailUsuario(); ?>" />
                
            </div>
            <button type="button" class="btn btn-outline-danger float-left" data-toggle="modal" data-target="#modal">Remover Tarefa</button>
            <button type="submit" class="btn btn-outline-success float-right">Atualizar Tarefa</button>
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
                        <p>Isso irá remover a tarefa definitivamente!</p>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="remover" data-dismiss="modal">Remover</button>
                    </div>
                </div>
            </div>
        </div>    
