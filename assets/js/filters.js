
let activeCategory = 'all';
let favoritesOnly = false;

const RESOURCES_PER_PAGE = 9;
let visibleLimit = RESOURCES_PER_PAGE;

const resourceGrid = document.getElementById('resourceGrid');
const resourceSearch = document.getElementById('resourceSearch');
const resourceCount = document.getElementById('resourceCount');
const emptyState = document.getElementById('emptyState');
const viewMoreBtn = document.getElementById('viewMoreBtn');

const sectionTitle = document.getElementById('resourceSectionTitle');
const sectionDescription = document.getElementById('resourceSectionDescription');

const DEFAULT_TITLE = 'Explore the Library';
const DEFAULT_DESCRIPTION =
    'Discover useful tools and resources for your next project.';

// Update section heading and browser tab
function updateSectionHeading(title, description) {
    if (sectionTitle) {
        sectionTitle.textContent = title;
    }

    if (sectionDescription) {
        sectionDescription.textContent = description;
    }

    document.title = `${title} | ResourceV2`;
}

// CATEGORY FILTER
document.querySelectorAll('.category-btn').forEach(button => {
    button.addEventListener('click', () => {

        document.querySelectorAll('.category-btn')
            .forEach(btn => btn.classList.remove('active'));

        button.classList.add('active');

        activeCategory = button.dataset.category;
        favoritesOnly = false;
        visibleLimit = RESOURCES_PER_PAGE;
        
        const categoryName =
            button.dataset.name || 'All Resources';
        
        if (activeCategory === 'all') {
            updateSectionHeading(
                'Explore the Library',
                'Browse our curated collection of design and development resources.'
            );
        } else {
            updateSectionHeading(
                categoryName,
                `Explore our ${categoryName.toLowerCase()} collection.`
            );
        }

        applyResourceFilters();
    });
});

// FAVORITES FILTER
document.getElementById('showFavorites')?.addEventListener('click', () => {

    favoritesOnly = true;
    activeCategory = 'all';
    visibleLimit = RESOURCES_PER_PAGE;

    document.querySelectorAll('.category-btn')
        .forEach(btn => btn.classList.remove('active'));

    document.querySelector('[data-category="all"]')
        ?.classList.add('active');

        updateSectionHeading(
            'Your Saved Resources',
            'All your favorite resources in one place.'
        );
        
    applyResourceFilters();
});

// SEARCH
resourceSearch?.addEventListener('input', () => {
    visibleLimit = RESOURCES_PER_PAGE;
    applyResourceFilters();
});

// VIEW MORE
viewMoreBtn?.addEventListener('click', () => {
    visibleLimit += RESOURCES_PER_PAGE;
    applyResourceFilters();
});

// APPLY FILTERS
function applyResourceFilters() {

    const query = resourceSearch?.value.toLowerCase().trim() || '';

    const cards = [
        ...resourceGrid.querySelectorAll('.resource-item')
    ];

    let matchingCards = [];

    cards.forEach(item => {

        const card = item.querySelector('.resource-card');

        if (!card) return;

        const categoryMatch =
            activeCategory === 'all' ||
            card.dataset.category === activeCategory;

        const title = card.dataset.title?.toLowerCase() || '';

        const description =
            card.querySelector('.card-description')
                ?.textContent.toLowerCase() || '';

        const searchMatch =
            title.includes(query) ||
            description.includes(query);

        const favoriteMatch =
            !favoritesOnly ||
            card.querySelector('.favorite-btn')
                ?.classList.contains('is-favorite');

        const matches =
            categoryMatch && searchMatch && favoriteMatch;

        item.dataset.matches = matches ? 'true' : 'false';

        if (matches) {
            matchingCards.push(item);
        }
    });

    // Show matching resources according to View More limit
    matchingCards.forEach((item, index) => {
        item.classList.toggle(
            'resource-hidden',
            index >= visibleLimit
        );
    });

    // Hide non-matching resources
    cards.forEach(item => {
        if (item.dataset.matches !== 'true') {
            item.classList.add('resource-hidden');
        }
    });

    const visibleCount = Math.min(
        matchingCards.length,
        visibleLimit
    );

    if (resourceCount) {
        resourceCount.textContent =
            `${visibleCount} of ${matchingCards.length} Resources`;
    }

    if (emptyState) {
        emptyState.hidden = matchingCards.length !== 0;
    }

    // View More visibility
    if (viewMoreBtn) {
        viewMoreBtn.style.display =
            matchingCards.length > visibleLimit
                ? 'inline-flex'
                : 'none';
    }
}

// INITIALIZE
updateSectionHeading(DEFAULT_TITLE, DEFAULT_DESCRIPTION);
applyResourceFilters();
