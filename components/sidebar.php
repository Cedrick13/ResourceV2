
<aside class="sidebar">

    <div class="sidebar-menu">

        <h3>LIBRARY</h3>

        <!-- ALL RESOURCES -->
        <button class="category-btn active" data-category="all">

            <i class="fa-solid fa-grip"></i>

            <span>All Resources</span>

            <small><?= $totalResources ?></small>

        </button>

        <!-- AUTOMATIC CATEGORY COUNTS -->
        <?php foreach ($categories as $category): ?>

            <?php
                $slug = $category['slug'];
                $count = $categoryCounts[$slug] ?? 0;
            ?>

            <button
                class="category-btn"
                data-category="<?= htmlspecialchars($slug) ?>"
            >

                <i class="<?= htmlspecialchars($category['icon']) ?>"></i>

                <span>
                    <?= htmlspecialchars($category['name']) ?>
                </span>

                <small><?= $count ?></small>

            </button>

        <?php endforeach; ?>

    </div>

    <!-- QUICK TIP -->
    <div class="quick-tip">

        <i class="fa-solid fa-lightbulb"></i>

        <h3>Quick Tip</h3>

        <p>
            Bookmark your essential assets for easy access later.
        </p>

        <button id="showFavorites">

            <i class="fa-regular fa-bookmark"></i>

            View Favorites

        </button>

    </div>

</aside>
