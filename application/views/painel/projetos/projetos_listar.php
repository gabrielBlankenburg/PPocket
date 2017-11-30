<div id="projetos">
    	<div class="container general">
    		<div class="row">
    			<div class="col-6">
    				<h3> <small>Projetos</small> <br> <strong>Cadastrados</strong> </h3>
    				<hr>
    			</div>	
    			<div class="col-6">
    				<div class="projetos-novo_wrapper__btn">
    					<button id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">Adicionar Projeto</button>
    				</div>
    			</div>
    		</div>
    		<div class="row">
    		    <!-- Cria novos projetos -->
    		    <div class="projeto-item projeto-add" id="projeto-novo" class="btn btn-default btn-principal float-right" data-toggle="modal" data-target=".modal-ppocket">
                	<!-- Projeto Item Header -->
                	<div class="projeto-item_header">
                		<div class="projeto-header_titulo"></div>
                	</div>
                	<!-- Projeto Item Corpo -->
                	<div class="projeto-item_corpo">
                	    <i class="fa fa-plus"></i>
                	</div>
                	<!-- Projeto Item Footer -->
                	<div class="projeto-item_footer">
                	</div>
                </div>
                <!-- Projetos já criados -->
                <template>
                    <projetos-listar v-for="item in conteudoListar" v-bind:projeto="item" v-bind:key="item.<?= Projeto::getChavePrimariaNome(); ?>"></projetos-listar>
                </template>
    		</div>	
    	</div>
    </div>
    
    
    <div id="modal" class="modal-ppocket">
        <div class="modal-wrapper">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h2 class="h3"><small>Cadastrar</small> <br> <strong>Projeto</strong></h2>
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
                        <label class="pp-form_label" for="nm_projeto">Nome do Projeto</label>
                        <input type="text" class="pp-form_input__text form-control" id="nm_projeto" name="nm_projeto" placeholder="Nome do projeto">
                        <label class="pp-form_label" for="dt_inicio">Data de Início</label>
                        <input type="date" class="pp-form_input__text form-control" id="dt_inicio" name="dt_inicio" placeholder="dd/mm/aaaa">        
                        <label class="pp-form_label" for="dt_termino">Data de Término</label>
                        <input type="date" class="pp-form_input__text form-control" id="dt_termino" name="dt_termino" placeholder="dd/mm/aaaa">
                        <label class="pp-form_label" for="ds_projeto">Descrição do projeto</label>
                        <textarea class="pp-form_input__text form-control" id="ds_projeto" name="ds_projeto" placeholder="Descrição do projeto"></textarea>
                        <label class="pp-form_label" for="cd_cliente">Cliente relacionado ao Projeto</label>
                        <select class="pp-form_input__text form-control" name="cd_cliente" id="cd_cliente">
                            <option>Escolha uma opção</option>
                            <?php foreach ($clientes as $cliente){ ?>
                                <option value="<?= $cliente['cd_cliente']; ?>"><?= $cliente['nm_cliente']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="multiple-inputs">
                            <label>Serviços</label>
                            <select class="pp-form_input__text form-control multiple-input" name="cd_servico[]" id="cd_servico[]">
                                <option>Escolha uma opção</option>
                                <?php foreach ($servicos as $servico) { ?>
                                    <option value="<?= $servico['cd_servico'] ?>"><?= $servico['nm_servico'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <br>
                        <div class="row">
                            <p class="d-block mx-auto text-danger remove-multiple-input"><i class="fa fa-close"></i> Remover serviço</p>
                        </div>
                        <div class="row">
                            <p class="d-block mx-auto text-primary add-multiple-input"><i class="fa fa-plus"></i> Adcionar serviço</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-default btn-outline-danger modal-btn_close float-left" data-dismiss="modal">Cancelar</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-default btn-outline-success float-right">Cadastrar Projeto</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>