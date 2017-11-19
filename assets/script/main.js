Vue.component('clientes-listar', {
    props: ['cliente'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"clientes/ver/'+"+'cliente.cd_cliente"><li class="listagem">{{ cliente.nm_cliente }}</li></a>'
});

Vue.component('projetos-listar', {
    props: ['projeto'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"projetos/ver/'+"+'projeto.cd_proejto"><li class="listagem">Projeto: {{ projeto.nm_projeto }} | Data de Início: {{ projeto.dt_inicio }} | Data de Término: {{ projeto.dt_termino }} | Descrição: {{ projeto.ds_projeto }} | Cliente: {{ projeto.nm_cliente }}</li></a>'
});

Vue.component('cargos-listar', {
    props: ['cargo'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"cargos/ver/'+"+'cargo.cd_cargo"><li class="listagem">{{ cargo.nm_cargo }}</li></a>'
});

Vue.component('funcionarios-listar', {
    props: ['funcionario'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"funcionarios/ver/'+"+'funcionario.cd_funcionario"><li class="listagem">Nome: {{ funcionario.nm_funcionario }} | Cargo: {{ funcionario.nm_cargo }}</li></a>'
});

Vue.component('servicos-listar', {
    props: ['servico'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'"+baseUrl+"servicos/ver/'+"+'servico.cd_servico"><li class="listagem">Nome: {{ servico.nm_servico }} | Descrição: {{ servico.ds_descricao }} | Valor: {{ servico.vl_servico }} |Cargo: {{ servico.nm_cargo }}</li></a>'
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
        document.getElementById('projetos')){
        listar(query);
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