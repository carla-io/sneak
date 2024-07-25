let products = [];
    let cart = [];
    const username = "{{ Auth::user()->name }}";
    const email = "{{ Auth::user()->email }}";

    $(document).ready(function () {
        // Fetch categories
        $.ajax({
            url: '/api/category',
            method: 'GET',
            success: function (response) {
                console.log('Categories data:', response);
                const categories = response.data; // Access the 'data' property
                if (Array.isArray(categories)) {
                    categories.forEach(category => {
                        $('#categorySelect').append(new Option(category.name, category.id));
                    });
                } else {
                    console.error('Categories data is not an array:', categories);
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch categories:', status, error);
            }
        });

        // Fetch products
        fetchProducts();

        // Search functionality
        $('#searchBar').on('input', function () {
            const query = $(this).val().toLowerCase();
            if (query.length > 1) { // Start searching only after 3 characters
                $.ajax({
                    url: '/api/search',
                    method: 'GET',
                    data: { query: query },
                    success: function (response) {
                        const searchResults = response.data; // Access the 'data' property
                        if (Array.isArray(searchResults)) {
                            displayProducts(searchResults);
                        } else {
                            console.error('Search results are not an array:', searchResults);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Failed to search products:', status, error);
                    }
                });
            } else {
                // Reset products if query is too short
                displayProducts(products);
            }
        });

        // Category filter functionality
        $('#categorySelect').on('change', function () {
            const categoryId = $(this).val();
            if (categoryId === 'all') {
                displayProducts(products);
            } else {
                displayProducts(products.filter(product => product.category_id == categoryId));
            }
        });

        // Redirect to cart page
        $('#floatingCartButton').on('click', function () {
            window.location.href = '/cart';
        });
    });

    function fetchProducts() {
        $.ajax({
            url: '/api/products',
            method: 'GET',
            success: function (response) {
                console.log('Products data:', response);
                const productsData = response.data; // Access the 'data' property
                if (Array.isArray(productsData)) {
                    products = productsData;
                    displayProducts(products);
                } else {
                    console.error('Products data is not an array:', productsData);
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch products:', status, error);
            }
        });
    }

    function displayProducts(products) {
        $('#productContainer').empty();
        if (Array.isArray(products)) {
            products.forEach(product => {
                const productCard = `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/images/${product.image}" class="card-img-top" alt="${product.product_name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.product_name}</h5>
                                <p class="card-text">${product.price}</p>
                                <button class="btn btn-primary" onclick="addToCart(${product.id})">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#productContainer').append(productCard);
            });
        } else {
            console.error('Products is not an array:', products);
        }
    }

    function addToCart(productId) {
        const product = products.find(p => p.id == productId);
        if (product) {
            const existingProduct = cart.find(p => p.id == productId);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                product.quantity = 1;
                product.username = username;
                product.email = email;
                cart.push(product);
            }
            $('#cartCount').text(cart.length);
            // Update cart count in floating button
            $('#floatingCartButton span').text(cart.length);
            // Store cart in session storage
            sessionStorage.setItem('cart', JSON.stringify(cart));
        } else {
            console.error('Product not found:', productId);
        }
    }