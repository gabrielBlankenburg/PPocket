<?php $query; ?>
<form class="offset-md-1 col-md-10" id="editar">
    <input type="hidden" name="cd_cliente" value="<?= $cliente->getChavePrimariaValor(); ?>"/>
    <div class="form-group">
        <label for="nm_cliente">Nome do cliente</label>
        <input type="text" class="form-control" id="nm_cliente" name="nm_cliente" value="<?= $cliente->getNomeCliente(); ?>" placeholder="Nome da empresa do cliente">
    </div>
    <div class="form-group">
        <label for="cd_cnpj">CNPJ</label>
        <input type="number" class="form-control" id="cd_cnpj" name="cd_cnpj" value="<?= $cliente->getCnpj(); ?>" placeholder="CNPJ">
    </div>
    <div class="form-group">
        <label for="cd_cpf">CPF</label>
        <input type="number" class="form-control" id="cd_cpf" name="cd_cpf" value="<?= $cliente->getCpf(); ?>" placeholder="CPF">
    </div>
    <div class="form-group">
        <label for="ds_email">Email</label>
        <input type="email" class="form-control" id="ds_email" name="ds_email" value="<?= $cliente->getEmail(); ?>" placeholder="exemplo@email.com">
    </div>
    <div class="form-group">
        <label for="cd_telefone">Telefone</label>
        <input type="text" class="form-control" id="cd_telefone" name="cd_telefone" value="<?= $cliente->getTelefone(); ?>" placeholder="Telefone do cliente">
    </div>
    <div class="form-group">
        <label for="nm_responsavel">Nome do cliente</label>
        <input type="text" class="form-control" id="nm_responsavel" name="nm_responsavel" value="<?= $cliente->getNomeResponsavel(); ?>" placeholder="Nome do cliente">
    </div>
    <div class="form-group">
        <label for="ds_responsavel_email">Email</label>
        <input type="email" class="form-control" id="ds_responsavel_email" name="ds_responsavel_email" value="<?= $cliente->getEmailResponsavel(); ?>" placeholder="exemplo@email.com">
    </div>
    <div class="form-group">
        <label for="cd_responsavel_telefone">Telefone</label>
        <input type="text" class="form-control" id="cd_responsavel_telefone" name="cd_responsavel_telefone" value="<?= $cliente->getTelefoneResponsavel(); ?>" placeholder="Telefone do cliente">
    </div>
    <button class="btn btn-danger">Remover Cliente</button>
    <button type="submit" class="btn btn-primary offset-sm-7">Atualizar Cliente</button>
</form>
