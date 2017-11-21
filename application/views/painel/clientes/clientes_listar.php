<div id="clientes">
    <div class="tables">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3> <small>Lista de</small> <br> <strong>Clientes</strong> </h3>
                    <hr>
                </div>  
                <div class="col-6">
                    <div class="projetos-novo_wrapper__btn">
                        <button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Adicionar Cliente</button>
                    </div>
                </div>
            </div>
            <table class="table table-listar">
                <thead class="table-listar_header">
                    <tr>
                        <th>Código</th>
                        <th>Nome Cliente</th>
                        <th>Email</th>
                        <th>Nome Responsável</th>
                        <th>Email Responsável</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody class="table-listar_body">
                    <template>
                        <clientes-listar v-for="item in conteudoListar" v-bind:cliente="item" v-bind:key="item.<?= Cliente::getChavePrimariaNome(); ?>"></clientes-listar>
                    </template>
                </tbody>
                <tfoot class="table-listar_footer">
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>


<!-- Modal Cliente -->

<div id="modal" class="modal-ppocket">
        <div class="modal-wrapper">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3"><small>Cadastrar</small> <br> <strong>Cliente</strong></h2>
                        </div>
                        <div class="col">
                            <p class="float-right modal-close modal-btn_close" data-dismiss="modal"><i class="fa fa-close"></i></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form class="pp-form" id="inserir">
                    <div class="form-group">
                        <label class="pp-form_label" for="nm_cliente">Nome do cliente</label>
                        <input type="text" class="pp-form_input__text form-control" id="nm_cliente" name="nm_cliente" placeholder="Nome da empresa do cliente">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_cnpj">CNPJ</label>
                        <input type="number" class="pp-form_input__text form-control" id="cd_cnpj" name="cd_cnpj" placeholder="CNPJ">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_cpf">CPF</label>
                        <input type="number" class="pp-form_input__text form-control" id="cd_cpf" name="cd_cpf" placeholder="CPF">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="ds_email">Email</label>
                        <input type="email" class="pp-form_input__text form-control" id="ds_email" name="ds_email" placeholder="exemplo@email.com">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_telefone">Telefone</label>
                        <input type="text" class="pp-form_input__text form-control" id="cd_telefone" name="cd_telefone" placeholder="Telefone do cliente">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="nm_responsavel">Nome do cliente</label>
                        <input type="text" class="pp-form_input__text form-control" id="nm_responsavel" name="nm_responsavel" placeholder="Nome do cliente">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="ds_responsavel_email">Email</label>
                        <input type="email" class="pp-form_input__text form-control" id="ds_responsavel_email" name="ds_responsavel_email" placeholder="exemplo@email.com">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_responsavel_telefone">Telefone</label>
                        <input type="text" class="pp-form_input__text form-control" id="cd_responsavel_telefone" name="cd_responsavel_telefone" placeholder="Telefone do cliente">
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-default btn-outline-danger modal-btn_close" data-dismiss="modal">Cancelar</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-default btn-outline-success float-right">Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

 