@component('mail::message')
# Perfil adicionado no {{ config('app.name') }}


Agora você possui o perfil  **{{ $perfil }}**.

Mensagem enviada automaticamente.

Para desativar esta notificação entre no sistema e na parte de profile do usuário selecione gerenciar notificações.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent