import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/IndexDisciplina')
    },
    {
        path: '/create',
        component: require('./paginas/CadastroDisciplina')
    },   
    {
        path: '/show/:id',
        component: require('./paginas/ShowDisciplina')
    },  
    {
        path: '/edit/:id',
        component: require('./paginas/EditDisciplina')
    },  
    
];


const disciplina = new Vue({
    el: '#disciplina',
    router : new VueRouter({
                                routes,
                                linkActiveClass: 'is-active'
        })
 
});
