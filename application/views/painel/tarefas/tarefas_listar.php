<div id="tarefas">
    <div class="tables">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3> <small>Lista de</small> <br> <strong>Tarefas</strong> </h3>
                    <hr>
                </div>  
                <?php if ($this->session->userdata('cd_permissao') != 1){ ?>
                    <div class="col-6">
                        <div class="projetos-novo_wrapper__btn">
                            <button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Adicionar Tarefa</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <table class="table table-listar">
                <thead class="table-listar_header">
                    <tr>
                        <th>Tarefa</th>
                        <th>Projeto</th>
                        <th>Serviço</th>
                        <th>Funcionário</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody class="table-listar_body">
                    <template>
                        <tarefas-listar v-for="item in conteudoListar" v-bind:Tarefa="item" v-bind:key="item.<?= Tarefa::getChavePrimariaNome(); ?>"></tarefas-listar>
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
                            <h2 class="h3"><small>Adicionar</small> <br> <strong>Tarefa</strong></h2>
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
                        <label class="pp-form_label" for="nm_tarefa">Tarefa</label>
                        <input type="text" class="pp-form_input__text form-control" id="nm_tarefa" name="nm_tarefa" placeholder="O nome dessa tarefa?">
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="ds_tarefa">Descrição</label>
                        <textarea class="pp-form_input__text form-control" id="ds_tarefa" name="ds_tarefa" placeholder="Detalhes sobre a tarefa"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_projeto">Projeto</label>
                        <select class="pp-form_input__text form-control" id="cd_projeto" name="cd_projeto">
                            <option value="0">Escolha um projeto</option>
                            <?php foreach ($projetos as $projeto) { ?>
                                <option value="<?= $projeto['cd_projeto'] ?>">
                                    <?= $projeto['nm_projeto']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                     <div class="form-group">
                        <label class="pp-form_label" for="cd_servico">Serviço</label>
                        <select class="pp-form_input__text form-control" id="cd_servico" name="cd_servico">
                            <option value="0" selected>Escolha um projeto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="pp-form_label" for="cd_funcionario">Funcionário</label>
                        <select class="pp-form_input__text form-control" id="cd_funcionario" name="cd_funcionario">
                            <option value="0">Escolha um projeto</option>
                        </select>
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