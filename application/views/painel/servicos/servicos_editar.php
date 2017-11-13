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
        <input type="hidden" name="cd_servico" value="<?= $cargo->getChavePrimariaValor(); ?>"/>
        <div class="form-group">
            <label for="nm_servico">Nome do Serviço</label>
            <input type="text" class="form-control" id="nm_servico" name="nm_servico" value="<?= $servico->getNomeServico(); ?>" placeholder="Nome do serviço">
            <textarea type="text" class="form-control" id="ds_servico" name="ds_servico" value="<?= $servico->getDescrivaoServico(); ?>" placeholder="Descrição do serviço"></textarea>
            <input type="number" class="form-control" id="vl_servico" name="vl_servico" value="<?= $servico->getValorServico(); ?>" placeholder="Nome do serviço">
        </div>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal">Remover Serviço</button>
        <button type="submit" class="btn btn-success offset-sm-7">Atualizar Serviço</button>
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
