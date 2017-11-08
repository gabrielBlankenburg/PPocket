// Carrega os itens do menu
Vue.component('menu-item', {
    props: ['item'],
    template: '<a v-bind:href="item.link"><li class="list-group-item">{{ item.conteudo }}</li></a>'
});

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
    listar(query);
    
    $('form').submit(function(){
        inserir();
        return false;
    })
});

function listar(objeto){
    objeto.forEach(function(e){
        painel.conteudoListar.push(e);
    });
}

function inserir(){
    var url = base_url+'/clientes/cadastra_cliente_action';
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