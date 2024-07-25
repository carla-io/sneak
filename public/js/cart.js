$(document).ready(function () {
    // Initialize the cart
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    displayCart(cart);
    updateCartCount();

    // Handle Proceed to Checkout
    $('#checkoutButton').on('click', function () {
        const token = localStorage.getItem('token');
        if (!token) {
            console.error('Token missing or expired');
            alert('You need to log in to proceed with checkout.');
            return;
        }

        if (cart.length === 0) {
            alert('Your cart is empty. Add some items before checking out.');
            return;
        }

        // Send cart data to the server
        $.ajax({
            url: "/api/checkout", // Ensure this is your correct endpoint
            method: "POST",
            data: JSON.stringify({ cart: cart }), // Send cart data to the server
            contentType: 'application/json',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                alert('Checkout successful!');
                sessionStorage.setItem('cart', JSON.stringify([])); // Clear the cart
                displayCart([]); // Clear the cart display
                updateCartCount(); // Update cart count
            },
            error: function (xhr, status, error) {
                console.error('Checkout failed:', status, error);
                alert('Checkout failed. Please try again later.');
            }
        });
    });
});

// Function to display cart items in the table
function displayCart(cart) {
    $('#cartTableBody').empty();
    let totalQuantity = 0;
    let totalPrice = 0;

    if (Array.isArray(cart) && cart.length > 0) {
        cart.forEach((item, index) => {
            const itemTotal = item.quantity * item.price;
            totalQuantity += item.quantity;
            totalPrice += itemTotal;

            $('#cartTableBody').append(`
                <tr>
                    <td>${item.product_name}</td>
                    <td><img src="/images/${item.image}" alt="${item.product_name}" width="50"></td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="changeQuantity(${index}, -1)">-</button>
                        ${item.quantity}
                        <button class="btn btn-sm btn-secondary" onclick="changeQuantity(${index}, 1)">+</button>
                    </td>
                    <td>₱${itemTotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger" onclick="removeFromCart(${index})">Remove</button>
                    </td>
                </tr>
            `);
        });

        $('#cartTableBody').append(`
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td><strong>₱${totalPrice.toFixed(2)}</strong></td>
                <td></td>
            </tr>
        `);
    } else {
        $('#cartTableBody').append('<tr><td colspan="5" class="text-center">No items in the cart.</td></tr>');
    }
}

// Function to update cart item count
function updateCartCount() {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    let totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
    $('#cartCount').text(totalItems);
}

// Function to change quantity of an item in cart
function changeQuantity(index, change) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    if (cart[index].quantity + change > 0) {
        cart[index].quantity += change;
        sessionStorage.setItem('cart', JSON.stringify(cart));
        displayCart(cart);
        updateCartCount();
    }
}

// Function to remove an item from cart
function removeFromCart(index) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    sessionStorage.setItem('cart', JSON.stringify(cart));
    displayCart(cart);
    updateCartCount();
}

// Function to add a product to cart
// Function to add a product to cart
function addToCart(productId) {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

    // Fetch the product data from the server
    $.ajax({
        url: `/api/products/${productId}`, // Adjusted endpoint to include productId
        method: 'GET',
        success: function(product) {
            // Log the product data for debugging
            console.log('Fetched product:', product);

            // Check if the product data is valid
            if (!product || !product.id) {
                console.error('Invalid product data:', product);
                alert('Failed to add product to cart.');
                return;
            }

            // Update cart with the fetched product data
            const existingProduct = cart.find(p => p.id === productId);
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                product.quantity = 1;
                cart.push(product);
            }

            // Update the cart in sessionStorage
            sessionStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            displayCart(cart);
        },
        error: function(xhr, status, error) {
            console.error('Failed to fetch product data:', status, error);
            alert('Failed to add product to cart. Please try again.');
        }
    });
}
