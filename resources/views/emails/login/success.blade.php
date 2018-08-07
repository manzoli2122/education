@component('mail::message')
# Acesso ao {{ config('app.name') }}

Verificamos o acesso ao  {{ config('app.name') }} às {{now()->format('d/m/Y H:i')}} pelo usuário {{ $usuario->name }}, caso não tenha realizado tal acesso favor entra contato com a DTIC.

Mensagem enviada automaticamente.
  
Obrigado,<br>
{{ config('app.name') }}
@endcomponent
