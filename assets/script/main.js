Vue.component('clientes-listar', { 
    props: ['cliente'],
    // Redireciona para o link do cliente pelo id
    template: '<tr><td>{{ cliente.cd_cliente }}</td><td>{{ cliente.nm_cliente }}</td><td>{{ cliente.ds_email }}</td><td>{{ cliente.nm_responsavel }}</td><td>{{ cliente.ds_responsavel_email }}</td><td><span class="text-warning"><i class="fa fa-envelope-o"></i></span><a v-bind:href="'+"'"+baseUrl+"clientes/ver/'+"+'cliente.cd_cliente"><span class="text-info"><i class="fa fa-pencil-square-o"></i></span></a><span class="text-danger"><i class="fa fa-window-close-o"></i></span></td></tr>'
});

Vue.component('projetos-listar', {
    props: ['projeto'],
    // Redireciona para o link do cliente pelo id
    template: '<div class="projeto-item"><!-- Projeto Item Header --><div class="projeto-item_header"><div class="projeto-header_titulo"><h2>{{ projeto.nm_projeto }}</h2></div></div><!-- Projeto Item Corpo --><div class="projeto-item_corpo"><ul class="list-unstyled projeto-corpo_ul"><li class="projeto-corpo_categoria"> <b>Data Término:</b> <small>{{ projeto.dt_termino }}</small> </li><li class="projeto-corpo_cliente"> <b>Cliente:</b> <small>{{ projeto.nm_cliente }}</small> </li><li class="projeto-corpo_descricao"> <b>Descrição:</b> <small>{{ projeto.ds_projeto }}</small></li></ul></div><!-- Projeto Item Footer --><div class="projeto-item_footer"><div class="row"><div class="btn btn-default btn-block btn-principal"><a v-bind:href="'+"'"+baseUrl+"projetos/ver/'+"+'projeto.cd_projeto"> Abrir </a></div></div></div></div>'
});

Vue.component('cargos-listar', {
    props: ['cargo'],
    // Redireciona para o link do cliente pelo id
    template: '<tr><td>{{ cargo.cd_cargo }}</td><td>{{ cargo.nm_cargo }}</td><td><a v-bind:href="'+"'"+baseUrl+"cargos/ver/'+"+'cargo.cd_cargo"><span class="text-info"><i class="fa fa-pencil-square-o"></i></span></a><span class="text-danger"><i class="fa fa-window-close-o"></i></span></td></tr>'
});

Vue.component('funcionarios-listar', {
    props: ['funcionario'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"funcionarios/ver/'+"+'funcionario.cd_funcionario"><li class="listagem">Nome: {{ funcionario.nm_funcionario }} | Cargo: {{ funcionario.nm_cargo }}</li></a>'
});

Vue.component('servicos-listar', {
    props: ['servico'],
    // Redireciona para o link do cliente pelo id
    template: '<tr><td>{{ servico.nm_servico }} </td><td>{{ servico.ds_servico }}</td><td>{{ servico.vl_servico }}</td><td>{{ servico.nm_cargo }}</td><td><a v-bind:href="'+"'"+baseUrl+"servicos/ver/'+"+'servico.cd_servico"><span class="text-info"><i class="fa fa-pencil-square-o"></i></span></a><span class="text-danger"><i class="fa fa-window-close-o"></i></span></td></tr>'
});

Vue.component('tarefas-listar', {
    props: ['tarefa'],
    // Redireciona para o link do cliente pelo id
    template: '<tr><td>{{ tarefa.cd_tarefa }} </td><td>{{ tarefa.nm_tarefa }}</td><td>{{ tarefa.nm_projeto }}</td><td>{{ tarefa.nm_servico }}</td><td>{{ tarefa.nm_funcionario }}</td><td><a v-bind:href="'+"'"+baseUrl+"tarefas/ver/'+"+'tarefa.cd_tarefa"><span class="text-info"><i class="fa fa-pencil-square-o"></i></span></a><span class="text-danger"><i class="fa fa-window-close-o"></i></span></td></tr>'
});

var painel = new Vue({
    el: '#painel',
    data: {
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
    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        success: function(resp){
            if(resp != 'false' && resp != false){
                painel.conteudoListar.push(resp);
                $('.bd-example-modal-lg').modal('toggle');
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
        success: function(resp){
            // Mudar isso
            if(resp == true || resp == 'true')
                alert('inserido com sucesso!!!');
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
        success: function(resp){
            if (resp == 'false' || resp == false){
                alert('Não foi possível remover do banco de dados');
            } else{
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