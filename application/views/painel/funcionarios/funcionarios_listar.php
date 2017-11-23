<div id="funcionarios" class="col-md-8">
    <ul class="list-group">
        <funcionarios-listar v-for="item in conteudoListar" v-bind:funcionario="item" v-bind:key="item.<?= Funcionario::getChavePrimariaNome(); ?>"></funcionarios-listar>
    </ul>
</div>
<!-- Large modal -->
<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
    Cadastrar Funcionario
</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="offset-md-1 col-md-10" id="inserir">
                <div class="form-group">
                    <label for="nm_cliente">Nome Completo</label>
                    <input type="text" class="form-control" id="nm_funcionario" name="nm_funcionario" placeholder="Nome do funcionário">
                </div>
                <div class="form-group">
                    <label for="cd_telefone">Telefone</label>
                    <input type="number" class="form-control" id="cd_telefone" name="cd_telefone" placeholder="Telefone do funcionário">
                </div>
                <div class="form-group">
                    <label for="cd_celular">Celular</label>
                    <input type="number" class="form-control" id="cd_celular" name="cd_celular" placeholder="Celular do funcionário">
                </div>
                <div class="form-group">
                    <label for="ds_email">Email</label>
                    <input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="funcionário@empresa.com">
                </div>
                <div class="form-group">
                    <label for="dt_nascimento">Data de nascimento</label>
                    <input type="text" class="form-control" id="dt_nascimento" name="dt_nascimento" placeholder="dia/mes/ano">
                </div>
                <div class="form-group">
                    <label for="vl_salario">Salário</label>
                    <input type="number" class="form-control" id="vl_salario" name="vl_salario" placeholder="salario">
                </div>
                <div class="form-group">
                    <label for="cd_cargo">Cargo</label>
                    <select class="form-control" name="cd_cargo" id="cd_cargo">
                        <option>Selecione</option>
                        <?php foreach ($cargos as $cargo) { ?>
                                <option value="<?= $cargo['cd_cargo']; ?>"><?= $cargo['nm_cargo']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cd_rg">RG</label>
                    <input type="number" class="form-control" id="cd_rg" name="cd_rg" placeholder="rg">
                </div>
                <div class="form-group">
                    <label for="cd_cpf">CPF</label>
                    <input type="number" class="form-control" id="cd_cpf" name="cd_cpf" placeholder="cpf">
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar Funcionario</button>
            </form>
        </div>
    </div>
</div>