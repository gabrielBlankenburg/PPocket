<div id="cargos">
    <div class="tables">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3> <small>Lista de</small> <br> <strong>Cargos</strong> </h3>
                    <hr>
                </div>  
                <div class="col-6">
                    <div class="projetos-novo_wrapper__btn">
                        <button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Adicionar Cargo</button>
                    </div>
                </div>
            </div>
            <table class="table table-listar">
                <thead class="table-listar_header">
                    <tr>
                        <th>Nome do Cargo</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody class="table-listar_body">
                    <template>
                        <cargos-listar v-for="item in conteudoListar" v-bind:cargo="item" v-bind:key="item.<?= Cargo::getChavePrimariaNome(); ?>"></cargos-listar>
                    </template>
                </tbody>
                <tfoot class="table-listar_footer">
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div id="modal" class="modal-ppocket">
    <div class="modal-wrapper">
        <div class="modal-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h2 class="h3"><small>Cadastrar</small> <br> <strong>Cargo</strong></h2>
                    </div>
                    <div class="col">
                        <p class="float-right modal-close modal-btn_close" data-dismiss="modal"><i class="fa fa-close"></i></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <form class="pp-form" id="inserir">
                <div class="form_error">
                  <?php echo validation_errors(); ?>
                </div>
                 
                <?php echo form_open(); ?>
                <div class="form-group">
                    <label for="nm_cargo">Nome do cargo</label>
                    <input type="text" class="pp-form_input__text form-control" id="nm_cargo" name="nm_cargo" size="30" value="<?php echo set_value('nm_cargo'); ?>" placeholder="Nome do cargo" required>
                </div>
                <button type="button" class="btn btn-outline-warning float-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-default btn-outline-success float-right">Cadastrar Cargo</button>
            </form>
        </div>
    </div>
</div>