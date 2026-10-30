
<aside class="sidebar">

    <div class="sidebar-menu">
        <h3>LIBRARY</h3>

        <button class="category-btn active" data-category="all">
            <i class="fa-solid fa-grip"></i>
            <span>All Resources</span>
        </button>

        <?php foreach ($categories as $category): ?>
            <button
                class="category-btn"
                data-category="<?= htmlspecialchars($category['slug']) ?>"
            >
                <i class="<?= htmlspecialchars($category['icon']) ?>"></i>
                <span><?= htmlspecialchars($category['name']) ?></span>
                <small><?= (int)$category['count'] ?></small>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="quick-tip">
        <i class="fa-solid fa-lightbulb"></i>
        <h3>Quick Tip</h3>
        <p>Bookmark your essential assets for easy access later.</p>
        <button id="showFavorites">
            <i class="fa-regular fa-bookmark"></i>
            View Favorites
        </button>
    </div>

</aside>
