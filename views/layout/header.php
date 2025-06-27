<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? htmlspecialchars($data['title']) : '' ?> | <?php echo isset($data['content']) ? htmlspecialchars($data['content']) : '' ?></title>
</head>
<body>
    <header>
       <?php require_once VIEW_PATH.'/layout/navbar.php'; ?>
    </header>