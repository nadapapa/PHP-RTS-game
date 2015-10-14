
Hali {{ $user['name'] }},

<a href="{{ url('auth/verify', $user['verification_code']) }}">Kattints ide a regisztráció megerősítéséhez!</a>

vagy másold be a böngésződ címsorába a linket és nyomj entert:
{{ url('auth/verify', $user['verification_code']) }}
