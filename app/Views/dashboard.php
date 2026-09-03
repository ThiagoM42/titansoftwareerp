<div class="dashboard">
    <aside class="sidebar">

        <div class="sidebar-user">
            <span>Logado como:</span>
            <strong><?= htmlspecialchars($user['name'] ?? '') ?></strong>
        </div>

        <nav class="sidebar-menu">
            <a href="<?= BASE_URL ?>/servicos/cadastrar">
                Cadastrar Serviço
            </a>
        </nav>

    </aside>

    <main class="dashboard-content">
        <h1>Bem-vindo ao Dashboard</h1>
        <p>Esta é a página principal do seu painel de controle.</p>
    </main>
</div>
