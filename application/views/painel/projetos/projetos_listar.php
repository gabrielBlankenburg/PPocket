<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastrar Novo Projeto</title>
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
                        <!--<label for="nm_projeto">Nome do Projeto</label>-->
                        <input type="text" class="form-control" id="nm_projeto" name="nm_projeto" placeholder="Nome do projeto">
                        <label for="dt_inicio">Data de Início</label>
                        <input type="date" class="form-control" id="dt_inicio" name="dt_inicio" placeholder="dd/mm/aaaa">        
                        <label for="dt_termino">Data de Término</label>
                        <input type="date" class="form-control" id="dt_termino" name="dt_termino" placeholder="dd/mm/aaaa">
                        <textarea type="text" class="form-control" id="ds_projeto" name="ds_projeto" placeholder="Descrição do projeto"></textarea>
                        <!--<input type="text" class="form-control" id="nm_cliente" name="nm_cliente" placeholder="Nome do Cliente associado ao Projeto">-->
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar Projeto</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>