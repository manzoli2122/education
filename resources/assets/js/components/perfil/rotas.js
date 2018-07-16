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
        path: '/show/:id',
        component: require('./paginas/Show')
    },  
    {
        path: '/edit/:id',
        component: require('./paginas/Edit')
    },  
    
    {
        path: '/:id/permissao',
        component: require('./paginas/Permissao')
    },  

    {
        path: '/:id/usuario',
        component: require('./paginas/Usuario')
    },  
    
];


const disciplina = new Vue({
    el: '#perfil',
    router : new VueRouter({
                                routes,
                                linkActiveClass: 'is-active'
        })
 
});
