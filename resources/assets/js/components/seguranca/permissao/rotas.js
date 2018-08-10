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
        path: '/edit/:id',
        component: require('./paginas/Edit')
    }, 
    {
        path: '/:id/perfis',
        component: require('./paginas/Perfis')
    },  
    
];


const permissao = new Vue({
    el: '#permissao',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
