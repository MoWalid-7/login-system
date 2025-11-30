<h2>Welcom, {{ $tempUser->name }}</h2>

<p>
اضغط على الرابط التالي لتفعيل حسابك:
</p>

<a href="http://localhost:8000/api/verify-email/{{ $token }}">
    اضغط هنا لتفعيل حسابك
</a>

{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
