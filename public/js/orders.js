// $(document).ready(function() {
//     const token = localStorage.getItem('token');

//     if (!token) {
//         console.error('Token missing or expired');
//         return;
//     }
    
//     $('#orderTable').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: '/api/orders',
//             type: 'GET',
//             headers: {
//                 'Authorization': 'Bearer ' + localStorage.getItem('token')
//             },
//             error: function(xhr, error, thrown) {
//                 console.error('AJAX Error:', error);
//                 console.log(xhr.responseText);
//             }
//         },
//         columns: [
//             { data: 'id', name: 'id' },
//             { data: 'username', name: 'username' }, // This is actually the `name` field
//             { data: 'product_name', name: 'product_name' },
//             { data: 'quantity', name: 'quantity' },
//             { data: 'total_price', name: 'total_price' },
//             { data: 'status', name: 'status' }
//         ]
//     });
// });

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
                return json.data; // Adjust if your response structure is different
            }
        },
        columns: [
                        { data: 'id', name: 'id' },
                        { data: 'username', name: 'username' }, // This is actually the `name` field
                        { data: 'product_name', name: 'product_name' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'total_price', name: 'total_price' },
                        { data: 'status', name: 'status' }
                    ]
    });
});

