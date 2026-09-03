<div class="login-wrap">

    <h1>Cadastrar usuário</h1>

    <?php if (isset($error)): ?>

        <div class="form-error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <form
        class="login-form"
        action="<?= BASE_URL ?>/cadastro"
        method="POST">

        <input
            type="text"
            name="name"
            placeholder="Nome"
            value="<?= isset($old['name']) ? htmlspecialchars($old['name']) : '' ?>"
            required>

        <input
            type="email"
            name="email"
            placeholder="email@email.com"
            value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>"
            required>

        <input
            type="password"
            name="password"
            placeholder="Senha"
            value="<?= isset($old['password']) ? htmlspecialchars($old['password']) : '' ?>"
            required>

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirmar senha"
            value="<?= isset($old['confirm_password']) ? htmlspecialchars($old['confirm_password']) : '' ?>"
            required>

        <div class="login-actions">

            <button
                type="submit"
                class="btn-enter">
                Cadastrar
            </button>

            <a href="<?= BASE_URL ?>/">
                Voltar
            </a>

        </div>

    </form>

</div>
