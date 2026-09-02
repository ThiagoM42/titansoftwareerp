<!-- <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>

    <h1>Login</h1> -->
<div class="login-wrap">
    <h1>Sistema de Controle de Serviços</h1>
    <form class="login-form" method="POST" action="<?= BASE_URL ?>/login">


        <input
            type="email"
            name="email"
            placeholder="E-mail">

        <input
            type="password"
            name="senha"
            placeholder="Senha">


        <div class="login-actions">
            <button
                type="submit"
                class="btn-enter">
                Entrar
            </button>

            <a href="<?= BASE_URL ?>/cadastro">
                Cadastrar usuário
            </a>
        </div>
    </form>
</div>

<!-- </body>

</html> -->
