Hola {{ $user['name'] }}, haz el click en el siguiente link para recuperar tu contraseña:
<a href="{{ url('/forgot-password/check/'.$hash) }}">Validar</a>