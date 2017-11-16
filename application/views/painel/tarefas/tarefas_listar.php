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
            <tarefas-listar v-for="item in conteudoListar" v-bind:tarefa="item" v-bind:key="item.<?= $chave_primaria; ?>"></tarefas-listar>
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
                        <textarea type="text" class="form-control" id="ds_tarefa" name="ds_tarefa"></textarea>
                        <input type="checkbox" class="form-control" id="ic_concluido" name="ic_concluido" value="ic_concluido"><label for="ic_concluido"></label>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Serviço</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>