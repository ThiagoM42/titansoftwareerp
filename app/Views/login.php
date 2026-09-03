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
    <?php if (isset($error)): ?>

        <div class="form-error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form class="login-form" method="POST" action="<?= BASE_URL ?>/login">


        <input
            type="email"
            name="email"
            placeholder="E-mail"
            value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>">

        <input
            type="password"
            name="password"
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
