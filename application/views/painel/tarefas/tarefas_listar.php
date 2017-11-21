<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tarefas</title>
</head>
<body>
    <div id="tarefas" class="col-md-8">
        <ul class="list-group">
            <tarefas-listar v-for="item in conteudoListar" v-bind:tarefa="item" v-bind:key="item.<?= Tarefa::getChavePrimariaNome(); ?>"></tarefas-listar>
        </ul>
    </div>
    <!-- Large modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Cadastrar Nova Tarefa</button>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="offset-md-1 col-md-10" id="inserir">
                    <div class="form-group">
                        <label for="nm_tarefa">Nome da tarefa</label>
                        <input type="text" class="form-control" id="nm_tarefa" name="nm_tarefa">
                        <label for="ds_tarefa">Descrição da tarefa</label>
                        <textarea class="form-control" id="ds_tarefa" name="ds_tarefa" placeholder="Como deverá ser executada a tarefa?"></textarea>
                        <label for="cd_projeto">Projeto</label>
                        <select class="form-control" name="cd_projeto" id="cd_projeto">
                            <option>Escolha um projeto</option>
                            <?php foreach ($projetos as $projeto) { ?>
                                <option value="<?= $projeto['cd_projeto'] ?>">
                                    <?= $projeto['nm_projeto'] ?>
                                </option> 
                            <?php } ?>
                        </select>
                        <label for="cd_servico">A que serviço essa tarefa está atrelada?</label>
                        <select class="form-control" name="cd_servico" id="cd_servico">
                            <option>Escolha um serviço</option>
                            <?php foreach ($servicos as $servico) { ?>
                                <option value="<?= $servico['cd_servico'] ?>">
                                    <?= $servico['nm_servico'] ?>
                                </option> 
                            <?php } ?>
                        </select>
                        <label for="cd_funcionario">Funcionário</label>
                        <select class="form-control" name="cd_funcionario" id="cd_funcionario">
                            <option>Escolha um funcionário</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Tarefa</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>