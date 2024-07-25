
    
$(document).ready(function () {
    var table = $('#productTable').DataTable({
        ajax: {
            url: "/api/products",
            dataSrc: "data"
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Product',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#productForm").trigger("reset");
                    $('#product_id').val('');
                    $('#productModal').modal('show');
                    $('#modal-title').html('Add Product');
                    $('#saveProductBtn').show();
                    $('#updateProductBtn').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'product_name' },
            { data: 'price' },
            {
                data: 'category',
                render: function (data, type, row) {
                    return data ? data.name : '';
                }
            },
            {
                data: 'image',
                render: function (data, type, row) {
                    return `<img src="/images/${data}" width="50" height="60">`;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-name="${row.product_name}" data-price="${row.price}" data-category_id="${row.category_id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });


     // Initialize validation
     $('#productForm').validate({
        rules: {
            product_name: {
                required: true,
                minlength: 3
            },
            price: {
                required: true,
                number: true
            },
            category_id: {
                required: true
            },
            // image: {
            //     required: true,
            //     extension: "jpg|jpeg|png|gif"
            // }
        },
        messages: {
            product_name: {
                required: "Please enter the product name",
                minlength: "Product name should be at least 3 characters"
            },
            price: {
                required: "Please enter the price",
                number: "Please enter a valid number"
            },
            category_id: {
                required: "Please select a category"
            },
            image: {
                required: "Please upload an image",
                extension: "Only image files (jpg, jpeg, png, gif) are allowed"
            }
        },
        errorPlacement: function (error, element) {
            // Display the error message next to the input field
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
       
     
    });


    // Handle Save Product Button Click
    $("#saveProductBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#productForm').valid()) {
        var formData = new FormData();
        formData.append('product_name', $('#product_name').val());
        formData.append('price', $('#price').val());
        formData.append('category_id', $('#category_id').val());
        formData.append('image', $('#image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "/api/create-product",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#productModal').modal('hide');
                $('#productTable').DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

      }
    });

    // Handle Edit Product Button Click
    $('#productTable tbody').on('click', 'button.edit-btn', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#product_id').val(data.id);
        $('#product_name').val(data.product_name);
        $('#price').val(data.price);
        $('#category_id').val(data.category_id);
       
        $('#productModal').modal('show');
        $('#modal-title').html('Edit Product');
        $('#saveProductBtn').hide();
        $('#updateProductBtn').show();
    });

    // Handle Update Product Button Click
    $("#updateProductBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#productForm').valid()) {
        var formData = new FormData();
        formData.append('product_id', $('#product_id').val());
        formData.append('product_name', $('#product_name').val());
        formData.append('price', $('#price').val());
        formData.append('category_id', $('#category_id').val());
        formData.append('image', $('#image')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "/api/update-product",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#productModal').modal('hide');
                $('#productTable').DataTable().ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

    }
    });

    // Handle Delete Product Button Click
    $('#productTable tbody').on('click', 'button.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                type: "DELETE",
                url: "/api/delete-product",
                data: { product_id: id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    table.ajax.reload();
                    alert(data.message);
                },
                error: function (error) {
                    console.log(error);
                    alert("Failed to delete product.");
                }
            });
        }
    });

    // Handle Import Form Submit
    $("#importForm").on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "/api/import-products",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#importModal').modal('hide');
                table.ajax.reload();
                alert(data.message);
            },
            error: function (error) {
                console.log(error);
                alert("Failed to import products.");
            }
        });
    });

});
