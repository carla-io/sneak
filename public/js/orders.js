$(document).ready(function () {
    $('#orderTable').DataTable({
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
            { data: 'username', name: 'username' }, // Use the `username` field
            { data: 'product_name', name: 'product_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'total_price', name: 'total_price' },
            { data: 'status', name: 'status' }
        ]
    });
});
