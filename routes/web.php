<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 

Route::get('/', function () {    return view('welcome');})->name('inicio');
Route::get('/home', function () {    return view('welcome');})->middleware('auth')->name('inicio');

Route::get('/log', 'HomeController@log' )  ;
      
 
 
// Rotas para autenticação
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

 
 /*

Route::get('/redis', function () {    
	$queue = Queue::push('LogMessage', array('message'=>'Time: '. time()   ));
	return $queue;
});


class LogMessage{
	public function fire($job,$date){
		File::append(app_path().'/queue.txt', $date['message'].PHP_EOL);

		App\Logging\LogService::enviarQueue(   
                    [ 
                        'acao' => 'Criar', 
                        'model' => $date ,  
                    ] 
                )  ;

		$job->delete();
		 
	}
}
*/