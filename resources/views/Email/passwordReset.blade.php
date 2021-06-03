@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''http://localhost:3000/response-reset?token='.$token'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent