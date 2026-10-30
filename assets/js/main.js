
const favoriteStorageKey = 'resourceV2Favorites';

let savedFavorites = JSON.parse(
    localStorage.getItem(favoriteStorageKey) || '[]'
);

document.querySelectorAll('.resource-card').forEach(card => {
    const button = card.querySelector('.favorite-btn');
    const title = card.dataset.title;
    const icon = button.querySelector('i');
    const count = button.querySelector('span');

    function updateFavoriteUI() {
        const active = savedFavorites.includes(title);

        button.classList.toggle('is-favorite', active);
        button.setAttribute('aria-pressed', String(active));

        icon.className = active
            ? 'fa-solid fa-heart'
            : 'fa-regular fa-heart';

        count.textContent =
            Number(card.dataset.favorites || 0) + (active ? 1 : 0);
    }

    updateFavoriteUI();

    button.addEventListener('click', () => {
        if (savedFavorites.includes(title)) {
            savedFavorites = savedFavorites.filter(item => item !== title);
        } else {
            savedFavorites.push(title);
        }

        localStorage.setItem(
            favoriteStorageKey,
            JSON.stringify(savedFavorites)
        );

        updateFavoriteUI();
        applyResourceFilters();
    });
});

document.getElementById('sortResources')
    .addEventListener('change', event => {
        const grid = document.getElementById('resourceGrid');
        const cards = [...grid.querySelectorAll('.resource-card')];

        const mode = event.target.value;

        cards.sort((a, b) => {
            if (mode === 'az') {
                return a.dataset.title.localeCompare(b.dataset.title);
            }

            if (mode === 'favorites') {
                return Number(b.querySelector('.favorite-btn span').textContent) -
                       Number(a.querySelector('.favorite-btn span').textContent);
            }

            return b.dataset.date.localeCompare(a.dataset.date);
        });

        cards.forEach(card => grid.appendChild(card));
    });
