$(document).ready(function () {
    // Handle Login
    $('#loginFormElement').on('submit', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: '/api/login',
            method: 'POST',
            data: {
                email: $('#login_email').val(),
                password: $('#login_password').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                localStorage.setItem('token', response.token);
                $('#loginMessage').text('Login successful!');
                window.location.href = '/';
            },
            error: function(xhr, status, error) {
                $('#loginMessage').text('Login failed. Please try again.');
            }
        });
    });
});
