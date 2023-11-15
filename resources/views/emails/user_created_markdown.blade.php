<!-- resources/views/emails/user_created_markdown.blade.php -->

@component('mail::message')
# Welcome to Dashboard

Hello {{ $user->name }},

Thank you for joining Dashboard! Your account has been successfully created.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/users'])
Go to Dashboard
@endcomponent

Thanks,<br>
YourApp Team
@endcomponent
