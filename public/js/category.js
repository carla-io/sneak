
$(document).ready(function () {
var table = $('#categoryTable').DataTable({
        ajax: {
            url: "/api/category",
            dataSrc: "data"
        },
        dom: 'Bfrtip',
        buttons: [
            'pdf',
            'excel',    
            {
                text: 'Add Category',
                className: 'btn btn-primary',
                action: function (e, dt, node, config) {
                    $("#ajaxForm").trigger("reset");
                    $('#category_id').val('');
                    $('#exampleModal').modal('show');
                    $('#modal-title').html('Add Category');
                    $('#saveBtn').show();
                    $('#updateBtn').hide();
                }
            }
        ],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'description' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${row.id}" data-name="${row.name}" data-description="${row.description}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ]
    });

     // Initialize validation
     $('#ajaxForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            description: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            name: {
                required: "Please enter the category name",
                minlength: "Product name should be at least 3 characters"
            },
            description: {
                required: "Please enter description",
                 minlength: "Description should be at least 5 characters"
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

    // Handle the save button click
    $("#saveBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#ajaxForm').valid()) {
        var formData = {
            name: $('#name').val(),
            description: $('#description').val()
        };
        $.ajax({
            type: "POST",
            url: "/api/create-category",
            data: formData,
            dataType: "json",
            success: function (data) {
                $('#exampleModal').modal('hide');
                $('.modal-backdrop').remove();
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });

       }
    });

      // Handle the edit button click
      $('#categoryTable tbody').on('click', 'button.edit-btn', function () {
        var data = table.row($(this).parents('tr')).data();
        
        $('#category_id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        
        $('#exampleModal').modal('show');
        $('#modal-title').html('Edit Category');
        $('#saveBtn').hide();
        $('#updateBtn').show();
    });

    // Handle the update button click
    $("#updateBtn").on('click', function (e) {
        e.preventDefault();
        if ($('#ajaxForm').valid()) {
        var id = $('#category_id').val();
        var formData = {
            category_id: id,
            name: $('#name').val(),
            description: $('#description').val()
        };
        $.ajax({
            type: "POST",
            url: "/api/update-category",
            data: formData,
            dataType: "json",
            success: function (data) {
                $('#exampleModal').modal('hide');
                table.ajax.reload();
            },
            error: function (error) {
                console.log(error);
            }
        });
       }
    });

     // Handle the delete button click
     $('#categoryTable tbody').on('click', 'button.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                type: "DELETE",
                url: "/api/delete-category",
                data: {
                    category_id: id
                 },
                 headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function (data) {
                    table.ajax.reload();
                    alert(data.message);
                },
                error: function (error) {
                    console.log(error);
                    alert("Failed to delete product.")
                }
            });
        }
    });

});


