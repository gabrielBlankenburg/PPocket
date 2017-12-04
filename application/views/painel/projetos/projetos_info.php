<div class="container general">
    <div class="row">
        <div class="col-6">
            <h3> <small>Informações do</small> <br> <strong>Projeto</strong> </h3>
            <hr>
        </div>  
        <div class="col-6">
            <div class="projetos-novo_wrapper__btn">
                <a href="<?= base_url(); ?>projetos/" class="btn btn-default btn-principal float-right">Voltar para projetos</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mostraProjeto container">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="h4"><b>Informações</b></h2>
                        <p><b>Nome:</b><br> <?= $projeto->getNomeProjeto(); ?></h3>
                        <p><b>Descrição:</b><br> <?= $projeto->getDescricaoProjeto(); ?></p>
                        <p><b>Cliente:</b> <br>
                            <?php foreach ($clientes as $cliente){ ?>
                                <?= $cliente['cd_cliente'] == $projeto->getChaveCliente() ? $cliente['nm_cliente'] : '' ?>
                            <?php } ?>
                        </p> 
                        <div class="row">
                            <div class="col-4">
                                <p><b>Data de início:</b><br> <?= $data = date("d-m-Y", strtotime($projeto->getDataInicio())); ?></p>
                            </div>
                            <div class="col-4">
                                <p><b>Data de Término:</b><br> <?= $data = date("d-m-Y", strtotime($projeto->getDataTermino())); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="h4"><b>Serviços cadastrados</b></h2>
                        <p>
                            <ul class="list-unstyled">
                            <?php 
                                foreach ($projeto->getServicos() as $projeto_servico) { 
                                    foreach ($servicos as $servico) { 
                                        if($servico['cd_servico'] == $projeto_servico->getChavePrimariaValor()) {
                                            echo '<li>'.$servico['nm_servico'].'</li>';
                                        } else { 
                                        
                                        };
                                    } 
                                }
                            ?>
                            </ul>
                        </p>
                        <p> <a type="button" href="<?= base_url(); ?>projetos/ver/<?= $projeto->getChavePrimariaValor() ?>" class="btn btn-default btn-outline-info" style="-webkit-appearance: none;"> Editar Projeto </a> </p>
                        <p> <button type="button" class="btn btn-default btn-outline-success"> Concluir Projeto </button> </p>
                    </div>
                </div>
            </div>
        </div>