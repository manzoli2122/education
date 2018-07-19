
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 

window.Vue = require('vue');

//Vue.use(iziToast);


Vue.component('datatable', require('./components/core/datatable.vue'));

Vue.component('crudCard', require('./components/core/crud/card.vue'));

Vue.component('crudHeader', require('./components/core/crud/header.vue'));

Vue.component('crudBotaoExcluir', require('./components/core/crud/botaoExcluir.vue'));

Vue.component('crudBotaoVoltar', require('./components/core/crud/botaoVoltar.vue'));

Vue.component('crudBotaoSalvar', require('./components/core/crud/botaoSalvar.vue'));

Vue.component('crudFormElemento', require('./components/core/crud/ElementoForm.vue'));

Vue.component('Formulario', require('./components/core/crud/Formulario.vue'));


Vue.component('select2', require('./components/core/SelectComponente.vue'));





//=========================================================================================================
//                            DATATABLE
//=========================================================================================================
window.datatablePadrao = function(seletorTabela, configEspecifica,
    lengthMenu = [
        [10, 25, 50, -1],
        [10, 25, 50, "Todos"]
    ]) {
    var csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;

    var configPadrao = {
        processing: true,
        serverSide: true,
        pagingType: "simple_numbers",
        lengthMenu: lengthMenu,
        language: { url: "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json" },
        ajax: {
            type: 'post',
            data: { '_token': csrf_token }
        },
        // Retira a busca a cada caractere digitado. Pesquisando apenas com Enter
        initComplete: function() {
            var $searchInput = $('div.dataTables_filter input');

            $searchInput.unbind();

            $searchInput.bind('keyup', function(e) {
                if (e.keyCode == 13) {
                    dataTable.search(this.value).draw();
                }
            });
        }
    }; 
    var config = _.merge(configPadrao, configEspecifica); 
    // Adiciona os campos para busca individual das colunas
    $(seletorTabela + ' thead th[pesquisavel]').each(function() {
        var title = $(seletorTabela + ' thead th').eq($(this).index()).text();
        $(this).html('<input type="text" pesquisavel placeholder="' + title + '" style="width:100%;" />');
    }); 
    var dataTable = $(seletorTabela).DataTable(config); 
    // Aplica a busca individual das colunas
    dataTable.columns().eq(0).each(function(colIdx) {
        $('input', dataTable.column(colIdx).header()).on('keypress change click', function(e) {
            if (e.type === 'change' || e.which === 13) {
                dataTable
                    .column(colIdx)
                     
                    .search(this.value)
                    .draw(); 
                e.stopPropagation();
            }
        }); 
        $('input', dataTable.column(colIdx).header()).on('click', function(e) {
            e.stopPropagation();
        });
    }); 
    return dataTable;
}





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
        timeout: 5000,
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
        timeout: 2000,
        position: posicao,
        color: '#00A65A',
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


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

//const app = new Vue({
  //  el: '#app'
//});
