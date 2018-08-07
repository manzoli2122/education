@component('mail::message')
# Perfil removido no {{ config('app.name') }}
 
Foi removido o perfil  **{{ $perfil }}** do seu usuário.

Mensagem enviada automaticamente.

Para desativar esta notificação entre no sistema e na parte de profile do usuário selecione gerenciar notificações.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent