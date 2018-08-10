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
      
    
];
 
const tranferirPerfil = new Vue({
    el: '#tranferirPerfil',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
