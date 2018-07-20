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
        path: '/:id/perfil',
        component: require('./paginas/Perfil') 
    },  

    {
        path: '/:id/perfil/adicionar',
        component: require('./paginas/AdicionarPerfil')
    }, 
     
    
];


const disciplina = new Vue({
    el: '#usuario',
    router : new VueRouter({
                                routes,
                                linkActiveClass: 'is-active'
        })
 
});
