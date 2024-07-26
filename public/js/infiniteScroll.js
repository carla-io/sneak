$(document).ready(function() {
    let page = 1;
    let loading = false;
    let endOfContent = false;

    function loadMoreProducts() {
        if (loading || endOfContent) return;

        loading = true;
        $('#loading').show();

        $.ajax({
            url: '/api/products?page=' + page,
            method: 'GET',
            success: function(data) {
                console.log(data); // Log the response to inspect it
                if (data.data.length === 0) {
                    endOfContent = true;
                    $('#loading').hide();
                    return;
                }

                data.data.forEach(function(product) {
                    console.log(product); // Log each product to inspect its properties

                    // Default values if any property is missing
                    const imageUrl = product.image || 'default-image.jpg';
                    const productName = product.name || 'No Name';
                    const productDescription = product.description || 'No Description';

                    $('#productContainer').append(`
                        <div class="product">
                            <img src="${imageUrl}" alt="${productName}">
                            <h3>${productName}</h3>
                            <p>${productDescription}</p>
                        </div>
                    `);
                });

                page++;
                loading = false;
                $('#loading').hide();
            },
            error: function() {
                loading = false;
                $('#loading').hide();
            }
        });
    }

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadMoreProducts();
        }
    });

    // Initial load
    loadMoreProducts();
});