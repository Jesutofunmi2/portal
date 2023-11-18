@extends('mail.layout.app')
@section('title')
    OTP Mail
@endsection
@section('content')
    <h3>Dear {{ $username }},</h3>
    <h3>your OTP is {{ $otp }}</h3>
    <h5>Please note that OTP expire within 15 minutes.</h5>
@endsection