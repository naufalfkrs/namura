<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= htmlspecialchars($title) ?? 'Aplikasi MVC'; ?></title>
      <link rel="stylesheet" href="?c=auth&m=css2">
  </head>
  <body>

    <?php include __DIR__ . '/header.php'; ?>

    <main>
        <?php include $viewFile; ?>
    </main>

    <?php include __DIR__ . '/footer.php'; ?>

  </body>
</html>