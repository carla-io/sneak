$(document).ready(function() {
    const token = localStorage.getItem('token');

    if (!token) {
        console.error('Token missing or expired');
        return;
    }

    $.ajax({
        url: '/api/sales', // Your endpoint
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        success: function(data) {
            const labels = data.map(order => order.product_name);
            const quantities = data.map(order => order.total_quantity);
            const sales = data.map(order => order.total_sales);

            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Change to 'line' or other types as needed
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Quantity',
                        data: quantities,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Total Sales',
                        data: sales,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Chart data fetch failed:', status, error);
            alert('Failed to load chart data. Please try again later.');
        }
    });


});

$(document).ready(function() {
    // Fetch Categories with Product Count Data
    $.ajax({
        url: '/api/most-used-category',
        method: 'GET',
        success: function(data) {
            var ctx = $('#mostUsedCategoryChart');
            var labels = data.map(function(category) {
                return category.name;
            });
            var counts = data.map(function(category) {
                return category.products_count;
            });
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Products',
                        data: counts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Products per Category'
                        }
                    }
                }
            });
        }
    });

    // Fetch Number of Users Registered Data
    $.ajax({
        url: '/api/users-registered',
        method: 'GET',
        success: function(data) {
            var ctx = $('#usersRegisteredChart');
            var labels = data.map(function(item) {
                return 'Month ' + item.month;
            });
            var counts = data.map(function(item) {
                return item.count;
            });
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Users Registered',
                        data: counts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
});


