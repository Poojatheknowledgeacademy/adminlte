<!-- resources/views/emails/user_created_markdown.blade.php -->

@component('mail::message')
# Welcome to Dashboard

Hello,

New course created by {{$userName}}

@component('mail::button', ['url' => 'http://127.0.0.1:8000/course'])
Go to Dashboard
@endcomponent

Thanks,<br>
TKA Team
@endcomponent
