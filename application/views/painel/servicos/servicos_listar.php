    <div id="servicos" class="col-md-8">
        <ul class="list-group">
            <servicos-listar v-for="item in conteudoListar" v-bind:servico="item" v-bind:key="item.<?= $chave_primaria; ?>"></servicos-listar>
        </ul>
    </div>
    
    <button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Adicionar novo serviço</button>
    
    <!-- Modal Novo Serviço -->
    <div id="modal" class="modal-ppocket">
    <div class="modal-wrapper">
        <div class="modal-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h2 class="h3"><small>Cadastrar</small> <br> <strong>Serviço</strong></h2>
                    </div>
                    <div class="col">
                        <p class="float-right modal-close modal-btn_close" data-dismiss="modal"><i class="fa fa-close"></i></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <form class="offset-md-1 col-md-10" id="inserir">
                <div class="form-group">
                    <label class="pp-form_label" for="nm_servico">Nome do Serviço</label>
                    <input type="text pp-form_input__text" class="form-control" id="nm_servico" name="nm_servico" placeholder="Nome do serviço">
                    <label class="pp-form_label" for="ds_servico">Descrição do Serviço</label>
                    <textarea class="form-control pp-form_input__text" id="ds_servico" name="ds_servico" placeholder="Descrição do serviço"></textarea>
                    <label class="pp-form_label" for="vl_servico">Valor do Serviço</label>
                    <input type="number pp-form_input__text" class="form-control" id="vl_servico" name="vl_servico" placeholder="Valor do serviço">
                    <label class="pp-form_label" for="cd_cargo">Cargo responsável pelo serviço</label>
                    <select class="form-control pp-form_input__text" name="cd_cargo" id="cd_cargo">
                        <option>Escolha uma opção</option>
                        <?php foreach ($cargos as $cargo){ ?>
                            <option value="<?= $cargo['cd_cargo']; ?>"><?= $cargo['nm_cargo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
               
        </div>
        <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-default btn-outline-danger modal-btn_close" data-dismiss="modal">Cancelar</button>
                        </div>
                        <div class="col">
                                <button type="submit" class="btn btn-default btn-outline-success float-right">Cadastrar</button>
                            </form>
                    </div>
                </div>
            </div>
    </div>
</div>