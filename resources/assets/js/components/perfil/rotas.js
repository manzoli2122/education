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
        path: '/edit/:id',
        component: require('./paginas/rascunho/Edit')
    },
    {
        path: '/show/:id',
        component: require('./paginas/rascunho/Show')
    }, 
     
];


const disciplina = new Vue({
    el: '#perfil',
    router : new VueRouter({
                                routes,
                                linkActiveClass: 'is-active'
        })
 
});
