
const FAVORITES_KEY = 'resourceV2Favorites';

// Get saved favorite IDs from this browser
function getFavorites() {
    try {
        return JSON.parse(localStorage.getItem(FAVORITES_KEY) || '[]');
    } catch {
        return [];
    }
}

function saveFavorites(ids) {
    localStorage.setItem(FAVORITES_KEY, JSON.stringify(ids));
}

let savedFavorites = getFavorites();

// Initialize favorite buttons
document.querySelectorAll('.resource-card').forEach(card => {

    const id = Number(card.dataset.id);
    const button = card.querySelector('.favorite-btn');

    const icon = button.querySelector('i');
    const count = button.querySelector('.favorite-count');

    function updateUI(isFavorite) {
        button.classList.toggle('is-favorite', isFavorite);
        button.setAttribute('aria-pressed', String(isFavorite));

        icon.className = isFavorite
            ? 'fa-solid fa-heart'
            : 'fa-regular fa-heart';
    }

    updateUI(savedFavorites.includes(id));

    button.addEventListener('click', async () => {

        if (button.disabled) return;

        const wasFavorite = savedFavorites.includes(id);
        const action = wasFavorite ? 'remove' : 'add';

        button.disabled = true;

        try {

            const response = await fetch('api/toggle-favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    action: action
                })
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Unable to update favorite');
            }

            if (action === 'add') {
                savedFavorites.push(id);
            } else {
                savedFavorites = savedFavorites.filter(item => item !== id);
            }

            saveFavorites(savedFavorites);

            // Update card count from JSON response
            count.textContent = result.favorites;
            card.dataset.favorites = result.favorites;

            updateUI(action === 'add');

            // Update total dashboard statistics if present
            updateFavoriteTotal();

        } catch (error) {

            alert(error.message);

        } finally {

            button.disabled = false;

        }
    });

});

// Calculate favorite count from currently displayed cards
function updateFavoriteTotal() {
    const totalElement = document.getElementById('totalFavorites');

    if (!totalElement) return;

    const cards = document.querySelectorAll('.resource-card');

    let total = 0;

    cards.forEach(card => {
        total += Number(card.dataset.favorites || 0);
    });

    totalElement.textContent = total;
}
