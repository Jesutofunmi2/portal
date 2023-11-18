@component('mail::message')
Dear {{ $fullname }}, click on the **Reset Password** button below to reset your password.

You can as well copy and paste the link below to a browser to reset your password.

@component('mail::button', ['url' => $link])
Reset Password
@endcomponent

@component('mail::subcopy')
    {{ $link }}
@endcomponent

@endcomponent