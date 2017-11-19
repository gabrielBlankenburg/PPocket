<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projetos</title>
</head>
<body>
    <div id="projetos" class="col-md-8">
        <ul class="list-group">
            <projetos-listar v-for="item in conteudoListar" v-bind:projeto="item" v-bind:key="item.<?= $chave_primaria; ?>"></projetos-listar>
        </ul>
    </div>
    <!-- Large modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Cadastrar Novo Projeto</button>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="offset-md-1 col-md-10" id="inserir">
                    <div class="form-group">
                        <label for="nm_projeto">Nome do Projeto</label>
                        <input type="text" class="form-control" id="nm_projeto" name="nm_projeto" placeholder="Nome do projeto">
                        <label for="dt_inicio">Data de Início</label>
                        <input type="date" class="form-control" id="dt_inicio" name="dt_inicio" placeholder="dd/mm/aaaa">        
                        <label for="dt_termino">Data de Término</label>
                        <input type="date" class="form-control" id="dt_termino" name="dt_termino" placeholder="dd/mm/aaaa">
                        <label for="ds_projeto">Descrição do projeto</label>
                        <textarea class="form-control" id="ds_projeto" name="ds_projeto" placeholder="Descrição do projeto"></textarea>
                        <label for="cd_cliente">Cliente relacionado ao Projeto</label>
                        <select class="form-control" name="cd_cliente" id="cd_cliente">
                            <option>Escolha uma opção</option>
                            <?php foreach ($clientes as $cliente){ ?>
                                <option value="<?= $cliente['cd_cliente']; ?>"><?= $cliente['nm_cliente']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="multiple-inputs">
                            <label>Serviços</label>
                            <select class="form-control multiple-input" name="cd_servico[]" id="cd_servico[]">
                                <option>Escolha uma opção</option>
                                <?php foreach ($servicos as $servico) { ?>
                                    <option value="<?= $servico['cd_servico'] ?>"><?= $servico['nm_servico'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button class="btn btn-primary add-multiple-input">Adcionar serviço</button>
                        <button class="btn btn-danger remove-multiple-input">Remover serviço</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Projeto</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>