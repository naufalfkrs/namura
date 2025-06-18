<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?? 'Aplikasi MVC'; ?></title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="src/css/style2.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <?php
            $controller = $_GET['c'] ?? '';
            if (in_array($controller, ['event', 'dashboard'])) {
                echo '<link rel="stylesheet" href="src/css/event.css">';
            }
        ?>
        <?php
            $controller = $_GET['c'] ?? '';
            if (in_array($controller, ['committee'])) {
                echo '<link rel="stylesheet" href="src/css/committee.css">';
            }
        ?>
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