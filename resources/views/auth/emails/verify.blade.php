Click here to verify your email: <a href="{{ $link = url('verify', $token).'?email='.urlencode($user->email) }}"> {{ $link }} </a>
