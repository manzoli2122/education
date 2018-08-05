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
    {
        path: '/:id/perfil/historico',
        component: require('./paginas/HistoricoPerfil') 
    },    
    
];
 
const usuario = new Vue({
    el: '#usuario',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
