<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


# Sobre o SGPM-TEMPLATE

## ACL

 - Baseado no Projeto ENTRUST disponivel em [ENTRUST](https://github.com/Zizaco/entrust).
 - Utiliza  [Cache](https://laravel.com/docs/5.6/cache/?target=_black)   para agilizar a verificação das permissões e perfis de um usuario.
  
### Utilização no Blade templates

No exemplo abaixo o codigo entre @perfil('Admin') e @endperfil só será redenrizado se o usuario possuir o perfil 'Admin'.

```php
@perfil('Admin')
	<li class="nav-item has-treeview ">
		<a href="#" class="nav-link active">
			<i class="nav-icon fa fa-lock"></i>
			<p>Segurança
				<i class="right fa fa-angle-left"></i>
			</p>
		</a> 
	</li>
@endperfil
```
	
No exemplo abaixo o codigo entre @permissao('visualizar-seguranca') e @endpermissao só será redenrizado se o usuario possuir a permissão 'visualizar-seguranca'.

```php
@permissao('visualizar-seguranca')
	<li class="nav-item has-treeview ">
		<a href="#" class="nav-link active">
			<i class="nav-icon fa fa-lock"></i>
			<p>Segurança
				<i class="right fa fa-angle-left"></i>
			</p>
		</a> 
	</li>
@endpermissao
```



### Utilização como Middleware


No exemplo abaixo a rota só será acessivel para usuarios que possuirem o perfil 'Admin'.
```php 
Route::get('/home', 'HomeController@home' )->middleware('perfil:Admin')->name('inicio');
```
 

No exemplo abaixo a rota só será acessivel para usuarios que possuirem a permissão  'visualizar-seguranca'.
```php 
Route::get('/home', 'HomeController@home' )->middleware('permissao:visualizar-seguranca')->name('inicio');
```



```php
public function __construct(  ){     
        $this->middleware('permissao:perfis');  
        $this->middleware('perfil:Admin');  
}
```



