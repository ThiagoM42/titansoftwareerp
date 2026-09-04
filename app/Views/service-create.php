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
                <label for="description">Descrição do Serviço:</label>
                <input type="text" id="description" name="description" value="<?= htmlspecialchars($old['description'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Preço do Serviço:</label>
                <input type="number" id="price" name="price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" step="0.01" required>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <button type="submit">Cadastrar Serviço</button>
                <a href="<?= BASE_URL ?>/dashboard" class="cancel-button">Cancelar</a>
            </div>
        </form>
    </div>
</div>
