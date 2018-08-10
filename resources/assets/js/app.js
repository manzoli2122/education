
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 

window.Vue = require('vue');
 

Vue.component('datatableService', require('./components/core/datatable/datatable.vue'));



Vue.component('crudCard', require('./components/core/crud/card.vue'));

Vue.component('crudHeader', require('./components/core/crud/header.vue'));

Vue.component('crudBotaoExcluir', require('./components/core/crud/botaoExcluir.vue'));

Vue.component('crudBotaoVoltar', require('./components/core/crud/botaoVoltar.vue'));

Vue.component('crudBotaoSalvar', require('./components/core/crud/botaoSalvar.vue'));

Vue.component('crudFormElemento', require('./components/core/crud/ElementoForm.vue'));

Vue.component('Formulario', require('./components/core/crud/Formulario.vue'));


Vue.component('select2', require('./components/core/crud/SelectComponente.vue'));


Vue.component('notifications', require('./components/notification/Notifications'));
Vue.component('notification', require('./components/notification/Notification'));



const header = new Vue({
    el: '#header',      
});
 



//=========================================================================================================
//                            ALERTA PROCESSAMENTO
//=========================================================================================================
window.alertProcessando = function() {
    $('body').addClass('loading');
}

window.alertProcessandoHide = function() {
    $('body').removeClass('loading');
}



window.alertErro = function(titulo, texto = "", posicao = "center", funcao = function() {}) {
    iziToast.show({
        theme: 'dark',
        position: posicao,
        color: '#DD4B39',
        title: titulo,
        titleColor: '#fff',
        titleSize: '14',
        message: texto,
        messageColor: '#fff',
         timeout: 10000,
       
        icon: 'fa fa-ban',
        iconColor: '#fff',
        closeOnEscape: true,
        onClosed: funcao
    });
}

window.toastErro = function(titulo, texto = "", funcao = function() {}) {
    alertErro(titulo, texto, 'bottomRight', funcao);
}






window.alertSucesso = function(titulo, texto = "", posicao = "center", funcao = function() {}) {
    iziToast.show({
        theme: 'dark',
        timeout: 10000,
       
        position: posicao,
        color: '#1F5688',
        title: titulo,
        titleColor: '#fff',
        titleSize: '14',
        message: texto,
        messageColor: '#fff',
        
        icon: 'fa fa-check',
        iconColor: '#fff',
        closeOnEscape: true,
        onClosed: funcao
    });
}

window.toastSucesso = function(titulo, texto = "", funcao = function() {}) {
    alertSucesso(titulo, texto, 'bottomRight', funcao);
}

 


window.alertConfimacao = function( titulo , texto , funcaoSIM  ) {
    iziToast.show({
        theme: 'dark',
        color: '#3C8DBC',
        titleColor: '#fff',
        messageColor: '#fff',
        timeout: false,
        icon: 'fa fa-question-circle-o',
        iconColor: '#fff',
        close: false,
        overlay: true,
        toastOnce: true,
        zindex: 999,
        title: titulo,
        message: texto,
        position: 'center',
        buttons: [
        
        ['<button>Sim</button>', function (instance, toast) {
            instance.hide({
                transitionOut: 'fadeOutUp', 
            }, toast);
            funcaoSIM();
        }],
        
        ['<button><b>Não</b></button>', function(instance, toast) {
            instance.hide({
                transitionOut: 'fadeOutUp', 
            }, toast ); 
        }, true]

        ],
        id: 'iziToastConfirmacao'
    });
}
