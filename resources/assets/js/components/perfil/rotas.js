import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    },
    {
        path: '/create',
        component: require('./paginas/Cadastro')
    },  
    {
        path: '/:id/permissao',
        component: require('./paginas/Permissao')
    }, 
    {
        path: '/:id/usuarios',
        component: require('./paginas/Usuarios')
    },  
    {
        path: '/:id/permissao/historico',
        component: require('./paginas/HistoricoPermissao')
    },   
     
];


const perfil = new Vue({
    el: '#perfil',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
