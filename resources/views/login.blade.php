<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/login.js') }}"></script>

</head>
<body>
    <div class="form-container">
        <div class="form-wrapper">
            <h2>Login</h2>
            <form id="loginFormElement" method="POST">
                <label>Email</label>
                <input type="email" id="login_email" placeholder="Email" required>

                <label>Password</label>
                <input type="password" id="login_password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p id="loginMessage"></p>
            <a href="register">Don't have an account? Register here.</a>
        </div>
    </div>
   
</body>
</html>
