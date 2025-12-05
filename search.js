const searchDatabase = {
    categories: [
        { name: 'Mens', url: 'Mens page.html', keywords: ['mens', 'men', 'male'] },
        { name: 'Womens', url: 'Womens Page.html', keywords: ['womens', 'women', 'female'] },
        { name: 'Outerwear', url: 'Outerwear.html', keywords: ['outerwear', 'jacket', 'coat', 'hoodie', 'sweater'] },
        { name: 'Innerwear', url: 'Innerwear.html', keywords: ['innerwear', 'vest', 'underwear'] },
        { name: 'T-shirts and Tops', url: 'T-shirts and Tops.html', keywords: ['t-shirt', 'tshirt', 'shirt', 'top', 'tops'] },
        { name: 'Bottoms', url: 'Bottoms.html', keywords: ['bottoms', 'pants', 'trousers', 'joggers'] },
        { name: 'Accessories', url: 'Accessories.html', keywords: ['accessories', 'accessory'] }
    ],
    products: [
        { name: 'Black Puffer Jacket', category: 'Outerwear', url: 'Puffer Jacket.html', keywords: ['puffer', 'jacket', 'black', 'warm', 'padded'], price: '£55.00' },
        { name: 'Raincoat', category: 'Outerwear', url: 'Outerwear.html', keywords: ['raincoat', 'rain', 'waterproof', 'coat'], price: '£40.00' },
        { name: 'Bomber Jacket', category: 'Outerwear', url: 'Outerwear.html', keywords: ['bomber', 'jacket'], price: '£60.00' },
        { name: 'Sweatshirt', category: 'Outerwear', url: 'Outerwear.html', keywords: ['sweatshirt', 'sweater', 'cotton'], price: '£35.00' },
        { name: 'Hoodie', category: 'Outerwear', url: 'Outerwear.html', keywords: ['hoodie', 'hood', 'casual'], price: '£45.00' }
    ]
};

function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if (!searchInput || !searchResults) {
        setTimeout(initSearch, 100);
        return;
    }

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim().toLowerCase();
        
        if (query.length === 0) {
            searchResults.innerHTML = '';
            searchResults.style.display = 'none';
            return;
        }

        const results = performSearch(query);
        displayResults(results, query);
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = e.target.value.trim().toLowerCase();
            if (query.length > 0) {
                const results = performSearch(query);
                if (results.categories.length > 0) {
                    window.location.href = results.categories[0].url;
                } else if (results.products.length > 0) {
                    window.location.href = results.products[0].url;
                }
            }
        }
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-box')) {
            searchResults.style.display = 'none';
        }
    });
}

function performSearch(query) {
    const results = {
        categories: [],
        products: []
    };

    searchDatabase.categories.forEach(category => {
        const nameMatch = category.name.toLowerCase().includes(query);
        const keywordMatch = category.keywords.some(kw => kw.includes(query));
        
        if (nameMatch || keywordMatch) {
            results.categories.push(category);
        }
    });

    searchDatabase.products.forEach(product => {
        const nameMatch = product.name.toLowerCase().includes(query);
        const keywordMatch = product.keywords.some(kw => kw.includes(query));
        const categoryMatch = product.category.toLowerCase().includes(query);
        
        if (nameMatch || keywordMatch || categoryMatch) {
            results.products.push(product);
        }
    });

    return results;
}

function displayResults(results, query) {
    const searchResults = document.getElementById('searchResults');
    
    if (results.categories.length === 0 && results.products.length === 0) {
        searchResults.innerHTML = '<div class="search-result-item no-results">No results found for "' + query + '"</div>';
        searchResults.style.display = 'block';
        return;
    }

    let html = '';
    
    if (results.categories.length > 0) {
        html += '<div class="search-section-title">Categories</div>';
        results.categories.slice(0, 3).forEach(category => {
            html += `<div class="search-result-item category-item" onclick="window.location.href='${category.url}'">
                        <span class="result-icon"></span>
                        <span class="result-text">${category.name}</span>
                     </div>`;
        });
    }

    if (results.products.length > 0) {
        html += '<div class="search-section-title">Products</div>';
        results.products.slice(0, 5).forEach(product => {
            html += `<div class="search-result-item product-item" onclick="window.location.href='${product.url}'">
                        <span class="result-icon">👕</span>
                        <div class="result-content">
                            <span class="result-text">${product.name}</span>
                            <span class="result-price">${product.price}</span>
                        </div>
                     </div>`;
        });
    }

    searchResults.innerHTML = html;
    searchResults.style.display = 'block';
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSearch);
} else {
    initSearch();
}

setTimeout(initSearch, 500);
