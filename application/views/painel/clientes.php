<div id="clientes" class="col-md-8">
    <ul class="list-group">
        <clientes-listar v-for="item in conteudoListar" v-bind:cliente="item" v-bind:key="item.<?= $chave_primaria; ?>"></clientes-listar>
    </ul>
</div>
<!-- Large modal -->
<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
Cadastrar Cliente
</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
         <form class="offset-md-1 col-md-10">
            <div class="form-group">
                <label for="nm_cliente">Nome do cliente</label>
                <input type="text" class="form-control" id="nm_cliente" name="nm_cliente" placeholder="Nome da empresa do cliente">
            </div>
            <div class="form-group">
                <label for="cd_cnpj">CNPJ</label>
                <input type="number" class="form-control" id="cd_cnpj" name="cd_cnpj" placeholder="CNPJ">
            </div>
            <div class="form-group">
                <label for="cd_cpf">CPF</label>
                <input type="number" class="form-control" id="cd_cpf" name="cd_cpf" placeholder="CPF">
            </div>
            <div class="form-group">
                <label for="ds_email">Email</label>
                <input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="exemplo@email.com">
            </div>
            <div class="form-group">
                <label for="cd_telefone">Telefone</label>
                <input type="text" class="form-control" id="cd_telefone" name="cd_telefone" placeholder="Telefone do cliente">
            </div>
            <div class="form-group">
                <label for="nm_responsavel">Nome do cliente</label>
                <input type="text" class="form-control" id="nm_responsavel" name="nm_responsavel" placeholder="Nome do cliente">
            </div>
            <div class="form-group">
                <label for="ds_responsavel_email">Email</label>
                <input type="email" class="form-control" id="ds_responsavel_email" name="ds_responsavel_email" placeholder="exemplo@email.com">
            </div>
            <div class="form-group">
                <label for="cd_responsavel_telefone">Telefone</label>
                <input type="text" class="form-control" id="cd_responsavel_telefone" name="cd_responsavel_telefone" placeholder="Telefone do cliente">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
        </div>
    </div>
</div>