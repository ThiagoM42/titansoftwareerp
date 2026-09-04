<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Titan OS' ?></title>

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

    <?= $content ?>

    <script
        src="<?= BASE_URL ?>/assets/js/dashboard.js"
        defer></script>
</body>

</html>
