@component('mail::message')
# Welcome to Dashboard

Hello {{ $user->name }},
Your account has been successfully created.

@component('mail::button', ['url' => Request::root() . route('activateaccount', ['remember_token' => $user->remember_token])])
Activate account
@endcomponent

Thanks,<br>
@endcomponent
