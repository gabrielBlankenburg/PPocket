Vue.component('clientes-listar', {
    props: ['cliente'],
    // Redireciona para o link do cliente pelo id
    template: '<a v-bind:href="'+"'clientes/ver/'+"+'cliente.cd_cliente"><li class="listagem">{{ cliente.nm_cliente }}</li></a>'
})

var painel = new Vue({
    el: '#painel',
    data: {
        menuItens: [
            {id: 0, conteudo: 'Projetos', link: '#'},
            {id: 1, conteudo: 'Clientes', link: '#'},
            {id: 2, conteudo: 'Serviços', link: '#'},
            {id: 3, conteudo: 'Funcionários', link: '#'}
        ],
        conteudoListar: []
    }
});

$(document).ready(function(){
    $('#inserir').submit(function(){
        inserir();
        return false;
    });
    
    $('#editar').submit(function(e){
        editar();
        return false;
    });
    
    if(document.getElementById('clientes')){
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
        url: url,
        data: data,
        success: function(resp){
            // Mudar isso
            if(resp == true || resp == 'true')
                alert('inserido com sucesso!!!');
        }
    });
}