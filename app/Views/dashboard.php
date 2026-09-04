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
                                <strong><?= $service['id_service'] ?></strong> -
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
                                <strong><?= $service['id_service'] ?></strong> -
                                <strong><?= htmlspecialchars($service['description']) ?></strong>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Nenhum serviço pendente.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="summary-column">
                <h2>Comissão pelos serviços</h2>
                <p style="border: 1px solid #000; padding: 10px;">R$ <?= number_format($comissionTotal, 2, ',', '.') ?></p>
            </div>
        </section>

        <!-- FILTROS DE PESQUISA -->
        <form
            class="dashboard-filters"
            action="<?= BASE_URL ?>/dashboard"
            method="GET">
            <input
                type="text"
                name="name"
                placeholder="Nome do serviço"
                value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">

            <!-- <input
                type="text"
                name="employee_name"
                placeholder="Nome do funcionário"
                value="<?= htmlspecialchars($_GET['employee_name'] ?? '') ?>"> -->

            <select name="employee_id">
                <option value="">
                    Todos os funcionários
                </option>

                <?php foreach ($employees ?? [] as $employee): ?>

                    <option
                        value="<?= $employee['id_user'] ?>"
                        <?= ($_GET['employee_id'] ?? '') == $employee['id_user']
                            ? 'selected'
                            : '' ?>>
                        <?= htmlspecialchars($employee['name']) ?>
                    </option>

                <?php endforeach; ?>

            </select>
            <input
                type="date"
                name="start_date"

                value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">

            <input
                type="date"
                name="end_date"
                value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">

            <button type="submit">
                Filtrar
            </button>
        </form>
        <!-- TABELA DE SERVIÇOS -->
        <section class="services-table-wrapper">
            <table class="services-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESCRIÇÃO</th>
                        <th>VALOR</th>
                        <th>FUNCIONÁRIO</th>
                        <th>STATUS</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= $service['id_service'] ?></td>
                                <td><?= htmlspecialchars($service['description']) ?></td>
                                <td>R$ <?= number_format($service['price'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($service['employee']) ?></td>
                                <td><?= htmlspecialchars($service['status']) ?></td>
                                <td>
                                    <!-- <a href="<?= BASE_URL ?>/servicos/resolve/<?= $service['id_service'] ?>" onclick="return confirm('Tem certeza que deseja resolver este serviço?')">Resolver</a>
                                      -->
                                    <?php if ($service['status'] === 'Pendente'): ?>
                                        <button class="resolve-button" data-service-id="<?= $service['id_service'] ?>" data-service-url="<?= BASE_URL ?>/servicos/resolve">Resolver</button>
                                    <?php else: ?>
                                        <span>Finalizado</span>
                                    <?php endif; ?>
                                </td>
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
