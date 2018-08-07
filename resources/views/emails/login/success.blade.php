@component('mail::message')
# Acesso ao {{ config('app.name') }}

Verificamos o acesso ao  {{ config('app.name') }} às {{now()->format('d/m/Y H:i')}} pelo usuário {{ $usuario->name }}, caso não tenha realizado tal acesso favor entra contato com a DTIC para informar possível fraude.

Mensagem enviada automaticamente.

Para desativar esta notificação entre no sistema e na parte de profile do usuário selecione gerenciar notificações.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
