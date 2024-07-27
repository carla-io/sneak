$(document).ready(function () {
    // Initialize DataTable
    var table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/api/orders',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json'
            },
            dataSrc: function (json) {
                console.log('Orders API Response:', json); // Debugging statement
                return json.data || []; // Adjust if your response structure is different
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error:', error);
                console.log(xhr.responseText);
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'username', name: 'username' },
            { data: 'product_name', name: 'product_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'total_price', name: 'total_price' },
            { data: 'status', name: 'status' },
            { data: 'shipper_name', name: 'shipper_name' },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });

    // Handle action button click
    $('#orderTable').on('click', '.select-shipper-btn', function () {
        var orderId = $(this).data('id');
        $('#order_id').val(orderId);
    
        // Fetch shippers
        $.ajax({
            url: '/api/shipper',
            method: 'GET',
            success: function (response) {
                console.log('Shipper data:', response);
                const shippers = response.data; // Access the 'data' property
                if (Array.isArray(shippers)) {
                    $('#shipper_id').empty(); // Clear the existing options
                    shippers.forEach(shipper => {
                        $('#shipper_id').append(new Option(shipper.shipper_name, shipper.id));
                    });
                } else {
                    console.error('Shippers data is not an array:', shippers);
                }
                $('#shipperModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch shippers:', status, error);
            }
        });
    });
    
    // Handle form submission
    $('#shipperForm').submit(function (e) {
        e.preventDefault();
        var orderId = $('#order_id').val(); // Ensure order ID is retrieved from hidden input
        var shipperId = $('#shipper_id').val(); // Get selected shipper ID
        var status = $('#status').val(); // Get selected status

        console.log('Order ID:', orderId);
        console.log('Shipper ID:', shipperId);
        console.log('Status:', status);

        if (!shipperId) {
            alert('Please select a shipper.');
            return;
        }

        $.ajax({
            url: '/api/orders/' + orderId + '/status',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json'
            },
            data: {
                shipper_id: shipperId,
                status: status
            },
            success: function (response) {
                $('#shipperModal').modal('hide');
                table.ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error updating order:', error);
                console.log(xhr.responseText);
            }
        });
    });
});
