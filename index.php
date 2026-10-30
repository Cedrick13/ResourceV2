
<?php

// ========================================
// RESOURCE DATA
// ========================================

$resourcesFile = __DIR__ . '/data/resources.json';

$resources = [];

if (file_exists($resourcesFile)) {
    $jsonData = file_get_contents($resourcesFile);
    $resources = json_decode($jsonData, true) ?? [];
}

// ========================================
// CATEGORY DATA
// ========================================

$categories = require __DIR__ . '/data/categories.php';

// ========================================
// AUTOMATIC CATEGORY COUNT
// ========================================

$categoryCounts = [];

foreach ($resources as $resource) {

    $slug = $resource['category'] ?? 'uncategorized';

    if (!isset($categoryCounts[$slug])) {
        $categoryCounts[$slug] = 0;
    }

    $categoryCounts[$slug]++;
}

// ========================================
// TOTAL COUNTS
// ========================================

$totalResources = count($resources);
$totalCategories = count($categories);


// Total favorites across all resources
$totalFavorites = array_sum(
    array_map(
        fn($resource) => (int)($resource['favorites'] ?? 0),
        $resources
    )
);

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

        <section class="resource-content" id="resources">

            <!-- RESOURCE STATISTICS -->
            <div class="stats-container">

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>

                    <div>
                        <h3><?= $totalResources ?></h3>
                        <p>Total Resources</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-folder"></i>
                    </div>

                    <div>
                        <h3><?= $totalCategories ?></h3>
                        <p>Total Categories</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa-solid fa-heart"></i>
                    </div>

                <div>
                    
        <h3 id="totalFavorites"><?= $totalFavorites ?></h3>
        <p>Total Favorites</p>
    </div>
</div>

            </div>

            <!-- SEARCH AND SORT -->
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

            <!-- SECTION HEADING -->
            <div class="section-heading">

                <div>
                    <h2>Explore Resources</h2>
                    <p>Discover useful tools and resources for your next project.</p>
                </div>

                <span id="resourceCount">
                    <?= $totalResources ?> Resources
                </span>

            </div>

            <!-- RESOURCE CARDS -->
            <div class="resource-grid" id="resourceGrid">

                <?php foreach ($resources as $resource): ?>

                    <?php include __DIR__ . '/components/resource-card.php'; ?>

                <?php endforeach; ?>

            </div>

            <!-- EMPTY STATE -->
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
