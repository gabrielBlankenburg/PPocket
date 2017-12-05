Vue.component('clientes-listar', { 
    props: ['cliente'],
    // Redireciona para o link do cliente pelo id
    template: '<tr>\
                    <td>{{ cliente.cd_cliente }}</td>\
                    <td>{{ cliente.nm_cliente }}</td>\
                    <td>{{ cliente.ds_email }}</td>\
                    <td>{{ cliente.nm_responsavel }}</td>\
                    <td>{{ cliente.ds_responsavel_email }}</td>\
                    <td>\
                        <a v-bind:href="'+"'"+baseUrl+"clientes/ver/'+"+'cliente.cd_cliente">\
                            <span class="text-info">\
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar\
                            </span>\
                        </a>\
                    </td>\
                </tr>'
});

Vue.component('projetos-listar', {
    props: ['projeto'],
    // Redireciona para o link do cliente pelo id
    template: '<div class="projeto-item">\
                    <!-- Projeto Item Header -->\
                    <div class="projeto-item_header">\
                        <div class="projeto-header_titulo">\
                            <h2>{{ projeto.nm_projeto }}</h2>\
                        </div>\
                    </div>\
                    <!-- Projeto Item Corpo -->\
                    <div class="projeto-item_corpo">\
                        <ul class="list-unstyled projeto-corpo_ul">\
                            <li class="projeto-corpo_cliente">\
                                <b>Cliente:</b> <small>{{ projeto.nm_cliente }}</small>\
                            </li>\
                            <li class="projeto-corpo_descricao">\
                                <b>Descrição:</b> <small>{{ projeto.ds_projeto }}</small>\
                            </li>\
                            <li class="projeto-corpo_categoria">\
                                <b>Data Término:</b> <small>{{ projeto.dt_termino }}</small>\
                            </li>\
                        </ul>\
                    </div>\
                    <!-- Projeto Item Footer -->\
                    <div class="projeto-item_footer">\
                        <div class="row"><div class="btn btn-default btn-block btn-principal">\
                            <a v-bind:href="'+"'"+baseUrl+"projetos/info/'+"+'projeto.cd_projeto" class="text-danger"> Ver projeto </a>\
                        </div>\
                    </div>\
                </div>'
});

Vue.component('cargos-listar', {
    props: ['cargo'],
    // Redireciona para o link do cliente pelo id
    template: '<tr>\
                    <td>{{ cargo.nm_cargo }}</td>\
                    <td>\
                        <a v-bind:href="'+"'"+baseUrl+"cargos/ver/'+"+'cargo.cd_cargo">\
                            <span class="text-info">\
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar\
                            </span>\
                        </a>\
                    </td>\
                </tr>'
});

Vue.component('funcionarios-listar', {
    props: ['funcionario'],
    // Redireciona para o link do cliente pelo id
    template: '<tr>\
                    <td>{{ funcionario.nm_funcionario }}</td>\
                    <td>{{ funcionario.ds_email }}</td>\
                    <td>{{ funcionario.nm_cargo }}</td>\
                    <td>\
                        <a v-bind:href="'+"'"+baseUrl+"funcionarios/ver/'+"+'funcionario.cd_funcionario">\
                            <span class="text-info">\
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar\
                            </span>\
                        </a>\
                    </td>\
                </tr>'
});

Vue.component('servicos-listar', {
    props: ['servico'],
    // Redireciona para o link do cliente pelo id
    template: '<tr>\
                    <td>{{ servico.nm_servico }} </td>\
                    <td>{{ servico.ds_servico }}</td>\
                    <td>R$ <span class="money"> {{ servico.vl_servico }} </span></td>\
                    <td>{{ servico.nm_cargo }}</td>\
                    <td>\
                        <a v-bind:href="'+"'"+baseUrl+"servicos/ver/'+"+'servico.cd_servico">\
                            <span class="text-info">\
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar\
                            </span>\
                        </a>\
                    </td>\
                </tr>'
});

Vue.component('tarefas-listar', {
    props: ['tarefa'],
    // Redireciona para o link do cliente pelo id
    template: '<tr>\
                    <td>{{ tarefa.nm_tarefa }}</td>\
                    <td><a class="text-white" v-bind:href="'+"'"+baseUrl+"projetos/ver/'+"+'tarefa.cd_projeto">{{ tarefa.nm_projeto }}</a></td>\
                    <td><a class="text-white" v-bind:href="'+"'"+baseUrl+"servicos/ver/'+"+'tarefa.cd_servico">{{ tarefa.nm_servico }}</a></td>\
                    <td>{{ tarefa.nm_funcionario }}</td>\
                    <td>\
                        <a v-bind:href="'+"'"+baseUrl+"tarefas/ver/'+"+'tarefa.cd_tarefa">\
                            <span class="text-info">\
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar\
                            </span>\
                        </a>\
                    </td>\
                </tr>'
});



var painel = new Vue({
    el: '#painel',
    data: {
        search: '',
        conteudoListar: []
    }
});

$(document).ready(function(){
    $('#inserir').submit(function(){
        inserir();
        return false;
    });
    
    $('#editar').submit(function(){
        editar();
        return false;
    });
    
    $('#remover').click(function(){
        remover();
    });
    
    $('.add-multiple-input').click(function(){
       addMultipleInput(); 
       return false;
    });
    
    $('.remove-multiple-input').click(function(){
       removeMultipleInput(); 
       return false;
    });
    
    if(document.getElementById('clientes') || document.getElementById('cargos') || 
        document.getElementById('funcionarios') || document.getElementById('servicos') || 
        document.getElementById('projetos') || document.getElementById('tarefas')){
        listar(query);
    }
    
    // Lista os serviços e funcionários das tarefas via ajax
    if(document.getElementById('tarefas') || document.getElementById('tarefa')){
        $('select').change(function(){
            if($(this).val() > 0){
                var aux = getSelect($(this));
                if (aux == false)
                    return;
            }
            if($(this).attr('id') == 'cd_projeto'){
                $('#cd_servico').html('<option value="0" selected>Escolha um projeto</option>');
                $('#cd_funcionario').html('<option value="0" selected>Escolha um funcionário</option>');
                if($(this).val() > 0){
                    aux.forEach(function(e){
                        $('#cd_servico').append('<option value="'+e.cd_servico+'">'+e.nm_servico+'</option>')
                    });
                }
            }
            else if($(this).attr('id') == 'cd_servico'){
                $('#cd_funcionario').html('<option value="0" selected>Escolha um funcionario</option>');
                if($(this).val() > 0){
                    aux.forEach(function(e){
                        $('#cd_funcionario').append('<option value="'+e.cd_funcionario+'">'+e.nm_funcionario+'</option>')
                    });
                }
            }
        })
    }
    
    // Jquery Mask
    $('.date').mask('00/00/0000');
      $('.time').mask('00:00:00');
      $('.date_time').mask('00/00/0000 00:00:00');
      $('.cep').mask('00000-000');
      $('.phone').mask('0000-0000');
      $('.phone_with_ddd').mask('(00) 0000-0000');
      $('.phone_us').mask('(000) 000-0000');
      $('.mixed').mask('AAA 000-S0S');
      $('.cpf').mask('000.000.000-00', {reverse: true});
      $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
      $('.money').mask('000.000.000.000.000,00', {reverse: true});
      $('.money2').mask("#.##0,00", {reverse: true});
      $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
          'Z': {
            pattern: /[0-9]/, optional: true
          }
        }
      });
      $('.ip_address').mask('099.099.099.099');
      $('.percent').mask('##0,00%', {reverse: true});
      $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
      $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
      $('.fallback').mask("00r00r0000", {
          translation: {
            'r': {
              pattern: /[\/]/,
              fallback: '/'
            },
            placeholder: "__/__/____"
          }
        });
      $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
});

// Lista todos os elementos
function listar(objeto){
    objeto.forEach(function(e){
        painel.conteudoListar.push(e);
    });
}

// Insere um elemento
function inserir(){
    var data = $('form').serialize();
    var $form = $(".pp-form .pp-form_input__text");
    
    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        beforeSend: function () {
            $('.painel-main').append('\
                <div id="alert-msg" class="alert alert-success fade show" role="alert" style="position: fixed;top: 10px; left: 35%; width: 35%; height: 50px; z-index:2000">\
                    <p>Processando... Aguarde um instante.</p>\
                </div>\
            ');
        },
        success: function(resp){
            if(resp != 'false' && resp != false){
                $(".alert").alert('close');
                painel.conteudoListar.push(resp);
                $('.modal-ppocket').modal('toggle');
                document.getElementById("inserir").reset();
                ChamaAlert('Cadastrado com sucesso :D');
            } else {
                ChamaAlert('Falha ao efetuar cadastro :(')
            }
        }
        
    });
}

// Edita um objeto
function editar(){
    var data = $('form').serialize();
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: data,
        beforeSend: function () {
            $('.painel-main').append('\
                <div id="alert-msg" class="alert alert-success fade show" role="alert" style="position: fixed;top: 10px; left: 35%; width: 35%; height: 50px; z-index:2000">\
                    <p>Processando... Aguarde um instante.</p>\
                </div>\
            ');
        },
        success: function(resp){
            // Mudar isso
            if(resp == true || resp == 'true')
                $(".alert").alert('close');
                window.location = '';
        }
    });
}

// Remove um objeto
function remover(){
    var data = $('form').serialize();
    $.ajax({
        method: 'POST',
        url: urlDel,
        data: data,
        beforeSend: function () {
            $('.painel-main').append('\
                <div id="alert-msg" class="alert alert-success fade show" role="alert" style="position: fixed;top: 10px; left: 35%; width: 35%; height: 50px; z-index:2000">\
                    <p>Processando... Aguarde um instante.</p>\
                </div>\
            ');
        },
        success: function(resp){
            if (resp == 'false' || resp == false){
                alert('Não foi possível remover do banco de dados');
            } else{
                $(".alert").alert('close');
                window.location = resp;
            }
        }
    });
}

function addMultipleInput(){
    $('.multiple-input').first().clone().appendTo('.multiple-inputs');
}

function removeMultipleInput(){
    if($('.multiple-input').length > 1)
        $('.multiple-input').last().remove();
}

function getSelect(e){
    var data = $('form').serialize();
    var aux;
    
    if($(e).attr('id') == 'cd_projeto'){
        var metodo = 'Servicos'
    }
    else if($(e).attr('id') == 'cd_servico'){
        var metodo = 'Funcionarios'
    }
    $.ajax({
        method: 'GET',
        url: baseUrl+'tarefas/apiGet'+metodo,
        data: data,
        async: false,
        success: function(resp){
            if (resp == 'false' || resp == false){
                aux = false;
            } else{
                aux = resp;
            }
        }
    });
    return aux
}

// Chama alerta para cadastro
function ChamaAlert($msg) {
    var alert_msg = $('#alert-msg');
    var alert_msg__p = $('#alert-msg p');
    
    alert_msg__p.text($msg);
    alert_msg.fadeIn();
    
    setTimeout(function(){
        alert_msg.fadeOut('slow');       
    }, 3000);
 
}