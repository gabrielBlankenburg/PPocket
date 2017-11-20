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
    <form class="offset-md-1 col-md-10" id="editar">
        <input type="hidden" name="cd_projeto" value="<?= $projeto->getChavePrimariaValor(); ?>"/>
        <div class="form-group">
            <label for="nm_projeto">Projeto</label> 
            <input type="text" class="form-control" id="nm_projeto" name="nm_projeto" value="<?= $projeto->getNomeProjeto(); ?>" placeholder="Nome do projeto">
            <label for="dt_inicio">Data de início</label>
            <input type="date" class="form-control" id="dt_inicio" name="dt_inicio" value="<?= $projeto->getDataInicio(); ?>" placeholder="dd/mm/aaaa">           
            <label for="dt_termino">Data de término</label>
            <input type="date" class="form-control" id="dt_termino" name="dt_termino" value="<?= $projeto->getDataTermino(); ?>" placeholder="dd/mm/aaaa">
            <label for="ds_projeto">Descrição</label>
            <textarea class="form-control" id="ds_projeto" name="ds_projeto"><?= $projeto->getDescricaoProjeto(); ?></textarea>
            <label for="cd_cliente">Cliente</label>
            <select class="form-control" name="cd_cliente" id="cd_cliente">
                <option>Escolha uma opção</option>
                <?php foreach ($clientes as $cliente){ ?>
                    <option value="<?= $cliente['cd_cliente']; ?>" <?= $cliente['cd_cliente'] == $projeto->getChaveCliente() ? 'selected' : '' ?>><?= $cliente['nm_cliente']; ?></option>
                <?php } ?>
            </select>    
            <div class="multiple-inputs">
                <label>Serviços</label>
                <?php foreach ($projeto->getServicos() as $projeto_servico) { ?>
                    <select class="form-control multiple-input" name="cd_servico[]" id="cd_servico[]">
                        <option>Escolha uma opção</option>
                        <?php foreach ($servicos as $servico) { ?>
                            <option value="<?= $servico['cd_servico'] ?>" 
                                <?= $servico['cd_servico'] == $projeto_servico->getChavePrimariaValor() ? 'selected'
                                : '' ?>>
                                    <?= $servico['nm_servico'] ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>
            <button class="btn btn-primary add-multiple-input">Adcionar serviço</button>
            <button class="btn btn-danger remove-multiple-input">Remover serviço</button>
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