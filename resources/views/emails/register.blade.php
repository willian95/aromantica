Hola {{ $user['name'] }}, haz el click en el siguiente link para validar tu correo:
<a href="{{ url('/email/check/'.$hash) }}">Validar</a>