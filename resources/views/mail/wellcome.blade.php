<h1>Bem Vindo {{ $userName }}!</h1>
<p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis cupiditate suscipit voluptatum error dolorem
    quae consectetur harum nobis, officiis libero, dolorum quod, adipisci nostrum beatae.
</p>
<hr>
<p style="padding-top: 12px; padding-bottom: 12px;">
    <a href="{{ $verifyEmailLink }}">Clique aqui</a> para confirmar a criação da sua conta!
</p>
<hr>
<p style="text-align: center; padding-top: 12px; padding-bottom: 12px; margin-bottom: 0;">
    <a href="{{ config('app.url') }}">
        {{ config('app.name') }}
    </a>
</p>
