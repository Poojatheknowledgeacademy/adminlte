@component('mail::message')
# Welcome to Dashboard

Hello {{ $user->name }},
Your account has been successfully created.
@component('mail::button', ['url' => route('usersmail.index', ['remember_token' => $user->remember_token])])
Activate acount
@endcomponent

Thanks,<br>

@endcomponent

