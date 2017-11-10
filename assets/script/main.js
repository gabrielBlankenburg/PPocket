Vue.component('clientes-listar', {
    props: ['cliente'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'clientes/ver/'+"+'cliente.cd_cliente"><li class="listagem">{{ cliente.nm_cliente }}</li></a>'
});

Vue.component('cargos-listar', {
    props: ['cargo'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'cargos/ver/'+"+'cargo.cd_cargo"><li class="listagem">{{ cargo.nm_cargo }}</li></a>'
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
    
    if(document.getElementById('clientes') || document.getElementById('cargos')){
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