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
        <h1>Dashboard</h1>
        <section class="dashboard-summary">
            <div class="summary-column">
                <h2>Últimos Serviços</h2>
                <ul>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <li>
                                <strong><?= htmlspecialchars($service['name']) ?></strong>
                                <span>R$ <?= number_format($service['price'], 2, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Nenhum serviço cadastrado.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="summary-column">
                <h2>Serviços Pendentes</h2>
                <ul>
                    <?php if (!empty($pendingServices)): ?>
                        <?php foreach ($pendingServices as $service): ?>
                            <li>
                                <strong><?= htmlspecialchars($service['name']) ?></strong>
                                <span>R$ <?= number_format($service['price'], 2, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Nenhum serviço pendente.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Preço</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= htmlspecialchars($service['name']) ?></td>
                                <td>R$ <?= number_format($service['price'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($service['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Nenhum serviço cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
