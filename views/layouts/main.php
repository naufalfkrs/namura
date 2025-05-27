<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?? 'Aplikasi MVC'; ?></title>
        <link rel="stylesheet" href="src/css/style2.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <?php include __DIR__ . '/header.php'; ?>

        <main>
            <?php include $viewFile; ?>
        </main>

        <?php include __DIR__ . '/footer.php'; ?>

        <script src="src/js/script.js"></script>

    </body>
</html>