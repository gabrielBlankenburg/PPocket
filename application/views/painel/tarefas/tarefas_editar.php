<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edição</title>
</head>
<body>
    <?php $query; ?>
    <div id="tarefa"></div>
    <form class="offset-md-1 col-md-10" id="editar">
        <input type="hidden" name="cd_tarefa" value="<?= $tarefa->getChavePrimariaValor(); ?>"/>
        <div class="form-group">
            <label for="nm_tarefa">Tarefa</label> 
            <input type="text" class="form-control" id="nm_tarefa" name="nm_tarefa" value="<?= $tarefa->getNomeTarefa(); ?>" placeholder="Nome da tarefa">
            <label for="ds_tarefa">Descrição</label>
            <textarea class="form-control" id="ds_tarefa" name="ds_tarefa"><?= $tarefa->getDescricaoTarefa(); ?></textarea>
            <label for="ic_concluido">Status</label>
            <select class="form-control" name="ic_concluido" id="ic_concluido">
                <option>Escolha uma opcao</option>
                <option value="0" <?= $tarefa->getConcluido() == 0 ? 'selected' : '' ?>>Aberta</option>
                <option value="1" <?= $tarefa->getConcluido() == 1 ? 'selected' : '' ?>>Concluída</option>
            </select>
            <label for="cd_projeto">Projeto</label>
            <select class="form-control" name="cd_projeto" id="cd_projeto">
                <option>Escolha uma opção</option>
                <?php foreach ($projetos as $projeto){ ?>
                    <option value="<?= $projeto['cd_projeto']; ?>" <?= $projeto['cd_projeto'] == $tarefa->getChaveProjeto() ? 'selected' : '' ?>><?= $projeto['nm_projeto']; ?></option>
                <?php } ?>
            </select>    
            <div class="form-group">
                <label class="pp-form_label" for="cd_servico">Serviço</label>
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
                <label class="pp-form_label" for="cd_funcionario">Funcionário</label>
                <select class="pp-form_input__text form-control" id="cd_funcionario" name="cd_funcionario">
                    <option value="0" selected>Escolha um funcionário</option>
                    <?php foreach ($funcionarios as $funcionario) { ?>
                        <option value="<?= $funcionario['cd_funcionario'] ?>" <?= $funcionario['cd_funcionario'] == $tarefa->getChaveFuncionario() ? 'selected' : '' ?>>
                            <?= $funcionario['nm_funcionario'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal">Remover Projeto</button>
        <button type="submit" class="btn btn-success offset-sm-7">Atualizar Projeto</button>
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
                    <p>Isso irá remover o serviço definitivamente!</p>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="remover" data-dismiss="modal">Remover</button>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>