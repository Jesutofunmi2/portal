@component('mail::message')
Dear {{ $fullname }}, click on the **Verify** button below to verify your email.

You can as well copy and paste the link below to a browser to verify your email.

@component('mail::button', ['url' => $link])
Verify
@endcomponent

@component('mail::subcopy')
    {{ $link }}
@endcomponent

@endcomponent