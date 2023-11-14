@component('mail::message')
# Welcome to Dashboard

Hello,

New Blog created sucessfully by {{ auth()->user()->name }}



Thanks,<br>

@endcomponent
