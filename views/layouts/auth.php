<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Auth Page') ?></title>
    <link rel="stylesheet" href="src/css/auth.css">
</head>
<body>
    <?php include $viewFile; ?>
</body>
</html>