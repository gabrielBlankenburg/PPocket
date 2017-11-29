<div id="funcionarios">
    <div class="tables">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3> <small>Lista de</small> <br> <strong>Funcionários</strong> </h3>
                    <hr>
                </div>  
                <div class="col-6">
                    <div class="projetos-novo_wrapper__btn">
                        <button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Cadastrar Funcionário</button>
                    </div>
                </div>
            </div>
             <table class="table table-listar">
                <thead class="table-listar_header">
                    <tr> 
                        <th>Nome do Funcionário</th>
                        <th>Email</th>
                        <th>Cargo</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody class="table-listar_body">
                    <template>
                        <funcionarios-listar v-for="item in conteudoListar" v-bind:funcionario="item" v-bind:key="item.<?= Funcionario::getChavePrimariaNome(); ?>"></funcionarios-listar>
                    </template>
                </tbody>
                <tfoot class="table-listar_footer">
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>
 
<!-- Modal Cadastrar novo funcionário -->
 
<div id="modal" class="modal-ppocket">
        <div class="modal-wrapper">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3"><small>Cadastrar</small> <br> <strong>Funcionário</strong></h2>
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
                    <label class="pp-form_label" for="nm_cliente">Nome Completo</label>
                    <input type="text" class="pp-form_input__text form-control" id="nm_funcionario" name="nm_funcionario" placeholder="Nome do funcionário">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_telefone">Telefone</label>
                    <input type="number" class="pp-form_input__text form-control" id="cd_telefone" name="cd_telefone" placeholder="Telefone do funcionário">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_celular">Celular</label>
                    <input type="number" class="pp-form_input__text form-control" id="cd_celular" name="cd_celular" placeholder="Celular do funcionário">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="ds_email">Email</label>
                    <input type="email" class="pp-form_input__text form-control" id="ds_email" name="ds_email" placeholder="funcionário@empresa.com">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="dt_nascimento">Data de nascimento</label>
                    <input type="text" class="pp-form_input__text form-control" id="dt_nascimento" name="dt_nascimento" placeholder="dia/mes/ano">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="vl_salario">Salário</label>
                    <input type="number" class="pp-form_input__text form-control" id="vl_salario" name="vl_salario" placeholder="salario">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_cargo">Cargo</label>
                    <select class="pp-form_input__text form-control" name="cd_cargo" id="cd_cargo">
                        <option>Selecione</option>
                        <?php foreach ($cargos as $cargo) { ?>
                                <option value="<?= $cargo['cd_cargo']; ?>"><?= $cargo['nm_cargo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_rg">RG</label>
                    <input type="number" class="pp-form_input__text form-control" id="cd_rg" name="cd_rg" placeholder="rg">
                </div>
                <div class="form-group">
                    <label class="pp-form_label" for="cd_cpf">CPF</label>
                    <input type="number" class="pp-form_input__text form-control" id="cd_cpf" name="cd_cpf" placeholder="cpf">
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