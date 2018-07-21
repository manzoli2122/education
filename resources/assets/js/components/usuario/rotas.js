import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    }, 
    {
        path: '/:id/perfil',
        component: require('./paginas/Perfil') 
    },   
   
     

//rascunhp
    {
        path: '/:id/perfil/adicionar',
        component: require('./paginas/rascunho/AdicionarPerfil')
    }, 
    {
        path: '/edit/:id',
        component: require('./paginas/rascunho/Edit')
    },  
    {
        path: '/create',
        component: require('./paginas/rascunho/Cadastro')
    },   
    {
        path: '/show/:id',
        component: require('./paginas/rascunho/Show')
    },  

    
];


const disciplina = new Vue({
    el: '#usuario',
    router : new VueRouter({
                                routes,
                                linkActiveClass: 'is-active'
        })
 
});
