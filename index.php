
<?php
$resourcesFile = __DIR__ . '/data/resources.json';

$resources = json_decode(
    file_get_contents($resourcesFile),
    true
) ?? [];

$categories = require __DIR__ . '/data/categories.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ResourceV2 | Design & Code Resources</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <?php include __DIR__ . '/components/header.php'; ?>

    <main class="main-layout">

        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <section class="resource-content">

            <div class="toolbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="search"
                        id="resourceSearch"
                        placeholder="Search code resources..."
                    >
                </div>

                <select id="sortResources">
                    <option value="recent">Most Recent</option>
                    <option value="az">A - Z</option>
                    <option value="favorites">Most Favorited</option>
                </select>
            </div>

            <div class="section-heading">
                <div>
                    <h2>Explore Resources</h2>
                    <p>Discover useful tools and resources for your next project.</p>
                </div>

                <span id="resourceCount">
                    <?= count($resources) ?> Resources
                </span>
            </div>

            <div class="resource-grid" id="resourceGrid">

                <?php foreach ($resources as $resource): ?>
                    <?php include __DIR__ . '/components/resource-card.php'; ?>
                <?php endforeach; ?>

            </div>

            <div class="empty-state" id="emptyState" hidden>
                <i class="fa-solid fa-folder-open"></i>
                <h3>No resources found</h3>
                <p>Try another search or category.</p>
            </div>

        </section>
    </main>

    <?php include __DIR__ . '/components/footer.php'; ?>

    <script src="assets/js/search.js"></script>
    <script src="assets/js/filters.js"></script>
    <script src="assets/js/main.js"></script>

</body>
</html>
