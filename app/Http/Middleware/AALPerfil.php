<?php 

namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;

class AALPerfil
{
	const DELIMITER = '|';
	protected $auth;
	
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}
	
	public function handle($request, Closure $next, $perfis)
	{
		if (!is_array($perfis)) {
			$perfis = explode(self::DELIMITER, $perfis);
		}
		if ($this->auth->guest() || !$request->user()->hasPerfil($perfis)) {
			abort(403 , "Você não tem o perfil necessário para essa operação" . $this->quebraArray($perfis));
		}
		return $next($request);
	}


	private function quebraArray($perfis){
		$string = ' ';
		foreach ($perfis as $key => $value) {
			$string .= $value . ', '; 
		}
		return $string;
	}
}
