<html>
    <body>
        <p>Ola {{ $Usuario->Nome ?? $Usuario->Login ?? "" }}</p>
        <p></p>
        <p>Segue seu login e senha para acesso do Dashboard.</p>
        <p>Login : {{ $Usuario->Login }} </p>
        <p>Senha : {{$Senha}} </p>
        <p></p>
        <p>Att, <br>
        Dashboard</p>
    </body>
</html>