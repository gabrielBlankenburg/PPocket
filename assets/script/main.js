// Carrega os itens do menu
Vue.component('menu-item', {
    props: ['item'],
    template: '<a v-bind:href="item.link"><li class="list-group-item">{{ item.conteudo }}</li></a>'
});

Vue.component('clientes-listar', {
    props: ['cliente'],
    template: '<a href="#"><li class="listagem">{{ cliente.nm_cliente }}</li></a>'
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
        clientesListar: []
    }
});

$(document).ready(function(){
    query.forEach(function(e){
        painel.clientesListar.push(e);
    });
    
    $('form').submit(function(e){
        e.preventDefault();
        var url = base_url+'/clientes/cadastra_cliente_action';
        var data = $('form').serialize();
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            success: function(resp){
                if(resp != 'false' && resp != false){
                    painel.clientesListar.push(resp);
                    $('.bd-example-modal-lg').modal('toggle');
                }
            }
        });
        return false;
    })
});