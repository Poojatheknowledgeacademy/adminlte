@component('mail::message')
# Welcome to Dashboard

Hello,

New Topic created sucessfully by {{ auth()->user()->name }}



Thanks,<br>

@endcomponent
