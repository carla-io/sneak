$(document).ready(function () {
    // Handle Registration
    $('#registerFormElement').on('submit', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: '/api/register',
            method: 'POST',
            data: {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                phone_number: $('#phone_number').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                localStorage.setItem('token', response.token);
                $('#registerMessage').text('Registration successful!');
                window.location.href = '/login';
            },
            error: function(xhr, status, error) {
                $('#registerMessage').text('Registration failed. Please try again.');
            }
        });
    });
});
