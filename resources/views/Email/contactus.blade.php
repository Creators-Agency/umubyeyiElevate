@component('mail::message')
# Contact us Message from {{$email}}

{{$message}}



Thanks,<br>
{{ config('app.name') }}
@endcomponent