$(document).ready(function () {
    var table = $('#shipperTable').DataTable({
        ajax: {
            url: "/api/shipper",
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
                text: 'Add Shipper',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#shipperForm").trigger("reset").find('.is-invalid').removeClass('is-invalid').end().find('.is-valid').removeClass('is-valid');
                    $('#shipper_id').val('');
                    $('#shipperModal').modal('show');
                    $('#modal-title').html('Add Shipper');
                    $('#saveShipperBtn').show();
                    $('#updateShipperBtn').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'shipper_name' },
            { data: 'shipper_contact' },
            { data: 'shipper_address' },
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
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-shipper_name="${row.shipper_name}" data-shipper_contact="${row.shipper_contact}" data-shipper_address="${row.shipper_address}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

    $('#shipperForm').validate({
        rules: {
            shipper_name: { required: true, minlength: 3 },
            shipper_contact: { required: true, minlength: 3, number: true },
            shipper_address: { required: true, minlength: 5 }
        },
        messages: {
            shipper_name: { required: "Please enter the shipper name", minlength: "Shipper name should be at least 3 characters" },
            shipper_contact: { required: "Please enter the shipper contact number", minlength: "Shipper contact number should be at least 3 characters" },
            shipper_address: { required: "Please enter the shipper address", minlength: "Shipper address should be at least 5 characters" }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });

    $("#saveShipperBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#shipperForm').valid()) {
            var formData = new FormData();
            formData.append('shipper_name', $('#shipper_name').val());
            formData.append('shipper_contact', $('#shipper_contact').val());
            formData.append('shipper_address', $('#shipper_address').val());
            formData.append('image', $('#image')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "/api/create-shipper",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#shipperModal').modal('hide');
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    $('#shipperTable tbody').on('click', '.edit-btn', function () {
        var data = table.row($(this).parents('tr')).data();

        $('#shipper_id').val(data.id);
        $('#shipper_name').val(data.shipper_name);
        $('#shipper_contact').val(data.shipper_contact);
        $('#shipper_address').val(data.shipper_address);

        $('#shipperModal').modal('show');
        $('#modal-title').html('Edit Shipper');
        $('#saveShipperBtn').hide();
        $('#updateShipperBtn').show();
    });

    $("#updateShipperBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#shipperForm').valid()) {
            var formData = new FormData();
            formData.append('shipper_id', $('#shipper_id').val());
            formData.append('shipper_name', $('#shipper_name').val());
            formData.append('shipper_contact', $('#shipper_contact').val());
            formData.append('shipper_address', $('#shipper_address').val());
            formData.append('image', $('#image')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "/api/update-shipper",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#shipperModal').modal('hide');
                    table.ajax.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    $('#shipperTable tbody').on('click', '.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this shipper?')) {
            $.ajax({
                type: "DELETE",
                url: "/api/delete-shipper",
                data: { shipper_id: id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    table.ajax.reload();
                    alert(data.message);
                },
                error: function (error) {
                    console.log(error);
                    alert("Failed to delete shipper.");
                }
            });
        }
    });
});
