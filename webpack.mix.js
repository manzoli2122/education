let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
 
mix.js('resources/assets/js/vendor.js', 'public/js');
  
//mix.scripts([ 'node_modules/admin-lte/dist/js/adminlte.js' ], 'public/js/adminlte.js');
    

 
mix.js('resources/assets/js/app.js', 'public/js');

//mix.sass('resources/assets/sass/app.scss', 'public/css');
 


mix.js('resources/assets/js/components/disciplina/rotas.js', 'public/js/disciplina.js');

mix.js('resources/assets/js/components/permissao/rotas.js', 'public/js/permissao.js');

mix.js('resources/assets/js/components/perfil/rotas.js', 'public/js/perfil.js');



/*
==========================================================================================================
							CSS
==========================================================================================================
*/
 
mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css', 
     
    'node_modules/izitoast/dist/css/iziToast.min.css', 
    'resources/assets/css/modalProcessamento.css',
    //'node_modules/datatables.net-bs/css/dataTables.bootstrap.css',
    //'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',

], 'public/css/bootstrap.css');
 
mix.styles([  'node_modules/select2/dist/css/select2.css', ], 'public/css/select2.css');
 
mix.styles([ 'node_modules/font-awesome/css/font-awesome.css',  'node_modules/ionicons/dist/css/ionicons.css' ], 'public/css/fonts.css');
 
// Template Admin LTE
//mix.styles([  'node_modules/admin-lte/dist/css/adminlte.min.css', ], 'public/css/adminlte.css');
  
//mix.styles([ 'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css', ], 'public/css/datatable.css');


// Fontes Font-awesome
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
mix.copy('node_modules/bootstrap/dist/css/bootstrap.css.map', 'public/css');

// Fontes Ionicons
mix.copy('node_modules/ionicons/dist/fonts', 'public/fonts');
 
mix.version();