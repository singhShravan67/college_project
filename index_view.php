<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Events - Advanced Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include Navigation -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <!-- Include Hero Section -->
        <?php include 'hero.php'; ?>

        <!-- Include Stats Section -->
        <?php include 'stats.php'; ?>

        <!-- Include Filter Bar -->
        <?php include 'filter_bar.php'; ?>

        <!-- Include Events Grid -->
        <?php include 'events_grid.php'; ?>
    </div>

    <!-- Include Modals -->
    <?php include 'modals.php'; ?>

    <!-- Include JavaScript -->
    <script src="script.js"></script>
</body>
</html>