<html>
    <body>
        <div><img src="http://moospayment.com/assets/img/logo_3.png" alt="" style="width: 25%;resizeMode: 'contain';"></div>
        <h1>Olá, <?php echo $user->nome; ?>!</h1>
        <p>Este é um email automatico da MOOS cartões de consumo.</p>
        <div>
            <p>
            Um novo cartão ou pulseira de código <?php echo $cartao->cartao_id; ?> foi criado na sua conta. Acesse o link abaixo para validar seu e-mail e acessar seu extrato on-line.
            </p>
            <a href="http://moospayment.com/user/{{$user->id}}/cartoes">Clique aqui</a>
        </div>
    </body>
</html>