// Vonn Cafe Master App Logic

document.addEventListener('DOMContentLoaded', () => {
    let allData = null;

    // Elements
    const homeView = document.getElementById('home-view');
    const menuView = document.getElementById('menu-view');
    const categoryContainer = document.getElementById('category-cards-container');
    const productsContainer = document.getElementById('products-container');
    const backBtn = document.getElementById('back-btn');
    const searchInput = document.getElementById('search-input');
    const menuTitle = document.getElementById('menu-title');
    const menuHero = document.getElementById('menu-hero');

    // Modal
    const modal = document.getElementById('product-modal');
    const modalImg = document.getElementById('modal-img');
    const modalTitle = document.getElementById('modal-title');
    const modalDesc = document.getElementById('modal-desc');
    const modalPrice = document.getElementById('modal-price');
    const closeModal = document.getElementById('close-modal');

    // Fetch Data
    fetch('data/menu.json')
        .then(res => res.json())
        .then(data => {
            allData = data;
            renderHome(data.categories);
        })
        .catch(err => console.error(err));

    // Render Home Categories
    function renderHome(categories) {
        categoryContainer.innerHTML = '';
        categories.forEach(cat => {
            const card = document.createElement('div');
            card.className = 'category-card';
            card.style.backgroundImage = `url('${cat.image}')`;

            card.innerHTML = `
                <div class="category-content">
                    <h2>${cat.name}</h2>
                    <p>${cat.items.length} Çeşit Ürün</p>
                </div>
            `;

            card.onclick = () => openCategory(cat);
            categoryContainer.appendChild(card);
        });
    }

    // Open Category Menu
    function openCategory(category) {
        // Set Header & Hero
        menuTitle.textContent = category.name;
        menuTitle.style.display = 'block'; // Ensure title is visible
        menuHero.style.backgroundImage = `url('${category.image}')`;

        // Dynamic Ambient Background for the whole view
        // We can set a style on the menuView element directly
        menuView.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.95)), url('${category.image}')`;
        menuView.style.backgroundSize = 'cover';
        menuView.style.backgroundPosition = 'center';
        menuView.style.backgroundAttachment = 'fixed';

        // Reset Search
        searchInput.value = '';
        document.querySelector('.search-box').style.gridColumn = 'span 2'; // Reset layout

        // Render Items
        renderProducts(category.items);

        // Transition Views
        homeView.classList.remove('active');
        menuView.classList.add('active');

        window.scrollTo(0, 0); // Reset scroll
    }

    // Render Product List
    function renderProducts(items) {
        productsContainer.innerHTML = '';

        if (items.length === 0) {
            productsContainer.innerHTML = '<p style="text-align:center; color: #666; padding: 20px;">Ürün bulunamadı.</p>';
            return;
        }

        items.forEach((item, index) => {
            const el = document.createElement('div');
            el.className = 'product-item';
            el.style.animationDelay = `${index * 0.05}s`; // Staggered animation

            // Set Background Image directly on the card
            // Lighter gradient so image is visible
            el.style.backgroundImage = `linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.1)), url('${item.image}')`;
            el.style.backgroundSize = 'cover';
            el.style.backgroundPosition = 'center';

            el.innerHTML = `
                <div class="product-details">
                    <span class="price-tag">${item.price}</span>
                    <h3>${item.name}</h3>
                    <p>${item.description}</p>
                </div>
            `;

            el.onclick = () => openModal(item);
            productsContainer.appendChild(el);
        });
    }

    // Search Logic
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();

        // Flatten all items from all categories if searching globally (Optional: here we search inside current cat or global?)
        // Let's implement global search if user types

        let results = [];

        if (menuView.classList.contains('active')) {
            // If inside a category, we filter THAT category's items?? 
            // Ideally for a "Master" app, let's just search the currently displayed list first.
            // But wait, the list is static. Let's make it smarter.
            // If I am in "Hot Drinks", search only Hot drinks.

            // To do this simply, we re-filter the current list.
            // But we don't have reference to 'currentCategory' easily unless we store it.
            // Let's store current items in memory.
        }
    });

    // Better Search: Filter visible items or Global Search?
    // Let's do a simple UI filter since the items are already DOM nodes? No, better to re-render.

    // Let's store current items
    let currentItems = [];

    const originalOpenCategory = openCategory;
    openCategory = function (category) {
        currentItems = category.items;
        originalOpenCategory(category);
    };

    searchInput.addEventListener('keyup', (e) => {
        const val = e.target.value.toLowerCase();
        const filtered = currentItems.filter(item =>
            item.name.toLowerCase().includes(val) ||
            item.description.toLowerCase().includes(val)
        );
        renderProducts(filtered);
    });


    // Back Button
    backBtn.onclick = () => {
        menuView.classList.remove('active');
        homeView.classList.add('active');
    };

    // Modal
    function openModal(item) {
        modalImg.src = item.image;
        modalTitle.textContent = item.name;
        modalDesc.textContent = item.description;
        modalPrice.textContent = item.price;
        modal.classList.add('active');
    }

    closeModal.onclick = () => modal.classList.remove('active');
    modal.onclick = (e) => { if (e.target === modal) modal.classList.remove('active'); };

});
