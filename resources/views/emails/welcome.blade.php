
Hali {{ $user['name'] }},

<a href="{{ url('auth/verify', $user['verification_code']) }}">Kattints ide a regisztráció megerõsítéséhez!</a>

vagy másold be a böngészõd címsorába a linket és nyomj entert:
{{ url('auth/verify', $user['verification_code']) }}
