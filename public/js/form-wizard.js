$(document).ready(function () {
    function loadCart() {
        return JSON.parse(sessionStorage.getItem('cart')) || [];
    }

    function loadUserInfo() {
        // Fetch user info and populate the fields in Step 2
        $.ajax({
            url: '/api/user',  // Change this URL to the correct endpoint for fetching the logged-in user
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token') // Adjust this line if you're using a different method for token storage
            },
            success: function(user) {
                let userInfoHtml = `
                    <p><strong>User Id:</strong> ${user.id}</p>
                    <p><strong>Name:</strong> ${user.username}</p>
                    <p><strong>Email:</strong> ${user.email}</p>
                    <p><strong>Address:</strong> ${user.address}</p>
                    <p><strong>Phone Number:</strong> ${user.phone_number}</p>
                `;
                $('#user-info').html(userInfoHtml);
            },
            error: function(error) {
                $('#user-info').html('<p>An error occurred while fetching user information.</p>');
                console.error('Error fetching user:', error);
            }
        });
    }

    function displayCartSummary() {
        let cart = loadCart();
        $('#summaryDetails').empty();  // Assuming #summaryDetails is where you want to show the summary
        let totalQuantity = 0;
        let totalPrice = 0;
        let summaryHtml = '';

        if (Array.isArray(cart) && cart.length > 0) {
            cart.forEach((item, index) => {
                const itemTotal = item.quantity * item.price;
                totalQuantity += item.quantity;
                totalPrice += itemTotal;

                summaryHtml += `
                    <p>
                        <strong>Product:</strong> ${item.product_name}<br>
                        <strong>Image:</strong> <img src="/images/${item.image}" alt="${item.product_name}" width="50"><br>
                        <strong>Quantity:</strong> ${item.quantity}<br>
                        <strong>Total:</strong> ₱${itemTotal.toFixed(2)}
                    </p>
                    <hr>
                `;
            });

            summaryHtml += `
                <p><strong>Total Quantity:</strong> ${totalQuantity}</p>
                <p><strong>Total Price:</strong> ₱${totalPrice.toFixed(2)}</p>
            `;
        } else {
            summaryHtml = '<p>No items in the cart.</p>';
        }

        $('#summaryDetails').html(summaryHtml);
    }


    function displayPaymentMethod() {
        let paymentMethod = $('input[name="paymentMethod"]:checked').val();
        let paymentMethodHtml = `
          <p><strong>Payment Method:</strong> ${paymentMethod}</p>
        `;
        $('#payment-method').html(paymentMethodHtml);
    }

    function generateOrderSummary() {
        // Load cart and user information
        
        // Load user info
        loadUserInfo();
        
        // Generate cart summary
        displayCartSummary();
        
        // Generate payment method display
        displayPaymentMethod();
    
        // Assemble the summary HTML
        let summaryHtml = `
            <h3>User Information</h3>
            ${$('#user-info').html()}
            <h3>Cart Items</h3>
            ${$('#summaryDetails').html()}
            <h3>Payment Method</h3>
            ${$('#payment-method').html()}
        `;
        
        // Set the summary HTML
        $('#summaryDetails').html(summaryHtml);
    }
    

    generateOrderSummary(); // Generate the order summary when the page loads

    $('#toStep2').on('click', function () {
        $('#step1').hide(); // Hide Step 1
        $('#step2').show(); // Show Step 2
    });

    $('#backToStep1').on('click', function () {
        $('#step2').hide(); // Hide Step 2
        $('#step1').show(); // Show Step 1
    });

    $('#toStep3').on('click', function () {
        $('#step2').hide(); // Hide Step 2
        $('#step3').show(); // Show Step 3
        $('#summaryDetails').text(generateOrderSummary()); // Populate order summary
    });

    $('#backToStep2').on('click', function () {
        $('#step3').hide(); // Hide Step 3
        $('#step2').show(); // Show Step 2
    });


   
});
