<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="service-create">
        <h1>Cadastrar Novo Serviço</h1>

        <?php if (isset($error)): ?>
            <div class="form-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/servicos/cadastrar-servico" method="POST" class="service-form">
            <div class="form-group">
                <label for="name">Nome do Serviço:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="price">Preço do Serviço:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>

            <button type="submit">Cadastrar Serviço</button>
        </form>
    </div>
</div>
