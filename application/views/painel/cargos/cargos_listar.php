<div id="cargos" class="col-md-8">
    <ul class="list-group">
        <cargos-listar v-for="item in conteudoListar" v-bind:cargo="item" v-bind:key="item.<?= $chave_primaria; ?>"></cargos-listar>
    </ul>
</div>
<!-- Large modal -->
<button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
    Cadastrar Cargo
</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
         <form class="offset-md-1 col-md-10" id="inserir">
            <div class="form-group">
                <label for="nm_cliente">Nome do cargo</label>
                <input type="text" class="form-control" id="nm_cliente" name="nm_cargo" placeholder="Nome do cargo">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cargo</button>
        </form>
        </div>
    </div>
</div>