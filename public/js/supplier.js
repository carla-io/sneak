$(document).ready(function () {
    // Initialize DataTable
    var table = $('#supplierTable').DataTable({
        ajax: {
            url: "/api/supplier",
            dataSrc: "data",
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error loading data: ' + textStatus, errorThrown);
            }
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',
            {
                text: 'Add Supplier',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#supplierForm").trigger("reset");
                    $('#supplier_id').val('');
                    $('#supplierModal').modal('show');
                    $('#modal-title').html('Add Supplier');
                    $('#saveSupplierBtn').show();
                    $('#updateSupplierBtn').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'supplier_name' },
            { data: 'contact_name' },
            { data: 'email' },
            { data: 'supplier_phone' },
            { data: 'address' },
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
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-supplier_name="${row.supplier_name}" data-contact_name="${row.contact_name}" data-email="${row.email}" data-supplier_phone="${row.supplier_phone}" data-address="${row.address}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    // Initialize validation
    $('#supplierForm').validate({
        rules: {
            supplier_name: {
                required: true,
                minlength: 3
            },
            contact_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            supplier_phone: {
                required: true,
                minlength: 6,
                number: true
            },
            address: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            supplier_name: {
                required: "Please enter the supplier name",
                minlength: "Supplier name should be at least 3 characters"
            },
            contact_name: {
                required: "Please enter the contact name",
                minlength: "Contact name should be at least 3 characters"
            },
            email: {
                required: "Please enter an email address",
                email: "Please enter a valid email address"
            },
            supplier_phone: {
                required: "Please enter a phone number",
                minlength: "Phone number should be at least 6 characters"
            },
            address: {
                required: "Please enter an address",
                minlength: "Address should be at least 5 characters"
            },
            image: {
                required: "Please select an image",
                extension: "Only image files (jpg, jpeg, png, gif) are allowed"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    // Handle Save Supplier Button Click
    $("#saveSupplierBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#supplierForm').valid()) {
            var formData = new FormData();
            formData.append('supplier_name', $('#supplier_name').val());
            formData.append('contact_name', $('#contact_name').val());
            formData.append('email', $('#email').val());
            formData.append('supplier_phone', $('#supplier_phone').val());
            formData.append('address', $('#address').val());
            formData.append('image', $('#supplier_image')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "/api/create-supplier",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#supplierModal').modal('hide');
                    $('#supplierTable').DataTable().ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Handle the edit button click
    $('#supplierTable tbody').on('click', '.edit-btn', function () {
        var data = table.row($(this).parents('tr')).data();
        
        $('#supplier_id').val(data.id);
        $('#supplier_name').val(data.supplier_name);
        $('#contact_name').val(data.contact_name);
        $('#email').val(data.email);
        $('#supplier_phone').val(data.supplier_phone);
        $('#address').val(data.address);

        $('#supplierModal').modal('show');
        $('#modal-title').html('Edit Supplier');
        $('#saveSupplierBtn').hide();
        $('#updateSupplierBtn').show();
    });

    // Handle Update Supplier Button Click
    $("#updateSupplierBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#supplierForm').valid()) {
            var formData = new FormData();
            formData.append('supplier_id', $('#supplier_id').val());
            formData.append('supplier_name', $('#supplier_name').val());
            formData.append('contact_name', $('#contact_name').val());
            formData.append('email', $('#email').val());
            formData.append('supplier_phone', $('#supplier_phone').val());
            formData.append('address', $('#address').val());
            formData.append('image', $('#supplier_image')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "/api/update-supplier",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#supplierModal').modal('hide');
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Handle Delete Supplier Button Click
    $('#supplierTable tbody').on('click', 'button.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this supplier?')) {
            $.ajax({
                type: "DELETE",
                url: "/api/delete-supplier",
                data: { supplier_id: id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    table.ajax.reload();
                    alert(data.message);
                },
                error: function (error) {
                    console.log(error);
                    alert("Failed to delete supplier.");
                }
            });
        }
    });

});
