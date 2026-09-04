<div class="dashboard">
    <aside class="sidebar">

        <div class="sidebar-user">
            <span>Logado como:</span>
            <strong><?= htmlspecialchars($user['name'] ?? '') ?></strong>
        </div>

        <nav class="sidebar-menu">
            <a href="<?= BASE_URL ?>/servicos/cadastrar-servico">
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
                                <strong><?= $service['id_service'] ?></strong>
                                <strong><?= htmlspecialchars($service['description']) ?></strong>
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
                                <strong><?= htmlspecialchars($service['description']) ?></strong>
                                <span>R$ <?= number_format($service['price'], 2, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Nenhum serviço pendente.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
        <!-- TABELA DE SERVIÇOS -->
        <section class="services-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESCRIÇÃO</th>
                        <th>VALOR</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= $service['id_service'] ?></td>
                                <td><?= htmlspecialchars($service['description']) ?></td>
                                <td>R$ <?= number_format($service['price'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($service['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nenhum serviço cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
