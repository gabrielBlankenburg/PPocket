// Carrega os itens do menu
Vue.component('menu-item', {
    props: ['item'],
    template: '<a v-bind:href="item.link"><li class="list-group-item">{{ item.conteudo }}</li></a>'
});

var painel = new Vue({
    el: '#painel',
    data: {
        menuItens: [
            {id: 0, conteudo: 'Projetos', link: '#'},
            {id: 1, conteudo: 'Clientes', link: '#'},
            {id: 2, conteudo: 'Serviços', link: '#'},
            {id: 3, conteudo: 'Funcionários', link: '#'}
        ]
    }
});