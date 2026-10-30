
let activeCategory = 'all';
let favoritesOnly = false;

document.querySelectorAll('.category-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.category-btn')
            .forEach(btn => btn.classList.remove('active'));

        button.classList.add('active');

        activeCategory = button.dataset.category;
        favoritesOnly = false;

        applyResourceFilters();
    });
});

document.getElementById('showFavorites')
    .addEventListener('click', () => {
        favoritesOnly = true;
        activeCategory = 'all';

        document.querySelectorAll('.category-btn')
            .forEach(btn => btn.classList.remove('active'));

        document.querySelector('[data-category="all"]')
            .classList.add('active');

        applyResourceFilters();
    });

function applyResourceFilters() {
    const query = document.getElementById('resourceSearch')
        .value.toLowerCase();

    const cards = [...document.querySelectorAll('.resource-card')];

    cards.forEach(card => {
        const categoryMatch =
            activeCategory === 'all' ||
            card.dataset.category === activeCategory;

        const searchMatch =
            card.dataset.title.toLowerCase().includes(query) ||
            card.querySelector('.card-description')
                .textContent.toLowerCase().includes(query);

        const favoriteMatch =
            !favoritesOnly ||
            card.querySelector('.favorite-btn')
                .classList.contains('is-favorite');

        card.hidden = !(categoryMatch && searchMatch && favoriteMatch);
    });

    const visibleCount = cards.filter(card => !card.hidden).length;

    document.getElementById('resourceCount').textContent =
        `${visibleCount} Resources`;

    document.getElementById('emptyState').hidden =
        visibleCount !== 0;
}
