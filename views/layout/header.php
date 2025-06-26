<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? htmlspecialchars($data['title']) : '' ?> | <?= isset($data['content']) ? htmlspecialchars($data['content']) : '' ?></title>
</head>
<body>
    <header>
        <?php require_once __DIR__ . '/../layout/navbar.php'; ?>
    </header>