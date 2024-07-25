<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/register.js') }}"></script>

</head>
<body>
    <div class="form-container">
        <div class="form-wrapper">
            <h2>Register</h2>
            <form id="registerFormElement" method="POST">
                <label>First Name</label>
                <input type="text" id="first_name" placeholder="First Name" required>

                <label>Last Name</label>
                <input type="text" id="last_name" placeholder="Last Name" required>

                <label>Username</label>
                <input type="text" id="username" placeholder="Username" required>

                <label>Email</label>
                <input type="email" id="email" placeholder="Email" required>

                <label>Address</label>
                <input type="text" id="address" placeholder="Address" required>

                <label>Phone number</label>
                <input type="text" id="phone_number" placeholder="Phone Number" required>

                <label>Password</label>
                <input type="password" id="password" placeholder="Password" required>

                <label>Confirm password</label>
                <input type="password" id="password_confirmation" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <p id="registerMessage"></p>
            <a href="login">Already have an account? Login here.</a>
        </div>
    </div>
    
</body>
</html>
