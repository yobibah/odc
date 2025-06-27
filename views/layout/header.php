<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($data['title']) ? htmlspecialchars($data['title']) : 'MedInfo Burkina'; ?>
        <?php if (!empty($data['content'])) echo ' | ' . htmlspecialchars($data['content']); ?>
    </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <?php require_once VIEW_PATH.'/layout/navbar.php'; ?>
    </header>
    <main class="flex-fill">