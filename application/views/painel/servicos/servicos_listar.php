<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Serviços</title>
</head>
<body>
    <div id="servicos" class="col-md-8">
        <ul class="list-group">
            <servicos-listar v-for="item in conteudoListar" v-bind:servico="item" v-bind:key="item.<?= $chave_primaria; ?>"></servicos-listar>
        </ul>
    </div>
    <!-- Large modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Cadastrar Novo Serviço</button>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="offset-md-1 col-md-10" id="inserir">
                    <div class="form-group">
                        <label for="nm_servico">Nome do Serviço</label>
                        <input type="text" class="form-control" id="nm_servico" name="nm_servico" placeholder="Nome do serviço">
                        <label for="ds_servico">Descrição do Serviço</label>
                        <textarea class="form-control" id="ds_servico" name="ds_servico" placeholder="Descrição do serviço"></textarea>
                        <label for="vl_servico">Valor do Serviço</label>
                        <input type="number" class="form-control" id="vl_servico" name="vl_servico" placeholder="Nome do serviço">
                        <label for="cd_cargo">Cargo responsável pelo serviço</label>
                        <select class="form-control" name="cd_cargo" id="cd_cargo">
                            <option>Escolha uma opção</option>
                            <?php foreach ($cargos as $cargo){ ?>
                                <option value="<?= $cargo['cd_cargo']; ?>"><?= $cargo['nm_cargo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Serviço</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>