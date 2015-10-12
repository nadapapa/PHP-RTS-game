
Hi {{ $user['name'] }},

Welcome to our site. Please click the following link to activate your account:

{{ url('auth/verify', $user['verification_code']) }}

Regards, CoderJP