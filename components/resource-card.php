
<article class="resource-card"
    data-id="<?= (int)$resource['id'] ?>"
    data-category="<?= htmlspecialchars($resource['category']) ?>"
    data-title="<?= htmlspecialchars($resource['title']) ?>"
    data-date="<?= htmlspecialchars($resource['date']) ?>"
    data-favorites="<?= (int)($resource['favorites'] ?? 0) ?>">

    <div class="card-category">
        <?= htmlspecialchars($resource['category_name']) ?>
    </div>

    <h3><?= htmlspecialchars($resource['title']) ?></h3>

    <p class="card-description">
        <?= htmlspecialchars($resource['description']) ?>
    </p>

    <div class="card-preview">
        <img
            src="<?= htmlspecialchars($resource['image']) ?>"
            alt="<?= htmlspecialchars($resource['title']) ?>"
            loading="lazy"
        >
    </div>

    <div class="card-footer">

        <a href="<?= htmlspecialchars($resource['url']) ?>"
           target="_blank"
           rel="noopener noreferrer">
            View File <i class="fa-solid fa-arrow-right"></i>
        </a>

        <button class="favorite-btn"
                type="button"
                aria-label="Add to favorites"
                aria-pressed="false">

            <i class="fa-regular fa-heart"></i>

            <span class="favorite-count">
                <?= (int)($resource['favorites'] ?? 0) ?>
            </span>

        </button>

    </div>

</article>
