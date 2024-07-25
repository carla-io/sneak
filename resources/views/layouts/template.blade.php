<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('dashboard/assets/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="user-id" content="{{ Auth::id() }}">
    <meta name="username" content="{{ Auth::user()->name ?? '' }}">

    <title>Dashboard</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('dashboard/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/config.js') }}"></script>

    <style>
        .cart-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 0 5px;
        }

        #floatingCartButton {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 1000;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #floatingCartButton:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .card-img-top {
            width: 100%;
            height: 200px; /* Adjust as needed */
            object-fit: cover; /* Ensures the image covers the area without stretching */
        }

        .navbar {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: auto; /* Ensure the width is appropriate */
        }
    </style>
</head>
<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <!-- Layout page -->
            <div class="layout-page">

                <!-- Navbar -->
                <nav class="layout-navbar shadow-none py-0">
                    <div class="container">
                        <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-8">
                            <!-- Menu logo wrapper: Start -->
                            <div class="navbar-brand app-brand demo d-flex py-0 me-4 me-xl-8">
                                <button class="navbar-toggler border-0 px-0 me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="tf-icons bx bx-menu bx-lg align-middle text-heading fw-medium"></i>
                                </button>
                                <a href="{{ route('home') }}" class="app-brand-link">
                                    <span class="app-brand-logo demo">
                                        <!-- SVG content here -->
                                    </span>
                                    <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">Sneat</span>
                                </a>
                            </div>
                            <!-- Menu logo wrapper: End -->
                            <!-- Menu wrapper: Start -->
                            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                                <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <i class="tf-icons bx bx-x bx-lg"></i>
                                </button>
                                <ul class="navbar-nav me-auto">
                                    <li class="nav-item">
                                        <a class="nav-link fw-medium" aria-current="page" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link fw-medium" href="landing-page.html#landingContact">Contact us</a>
                                    </li>
                                    <li class="nav-item mega-dropdown active">
                                        <a href="javascript:void(0);" class="nav-link dropdown-toggle navbar-ex-14-mega-dropdown mega-dropdown fw-medium" aria-expanded="false" data-bs-toggle="mega-dropdown" data-trigger="hover">
                                            <span data-i18n="Pages">Pages</span>
                                        </a>
                                        <div class="dropdown-menu p-4 p-xl-8">
                                            <!-- ... (existing dropdown content) ... -->
                                        </div>
                                    </li>
                                </ul>
                                <ul class="navbar-nav ms-auto d-flex align-items-center" id="auth-buttons">
                                    <!-- Auth buttons will be dynamically inserted here -->
                                </ul>
                            </div>
                            <!-- Menu wrapper: End -->
                        </div>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <!-- Add your content here -->
                        @yield('content')
                    </div>
                    <!-- /Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('dashboard/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('dashboard/assets/js/main.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/homepage.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const authButtons = document.getElementById('auth-buttons');
        if (authButtons) {
            fetch('/api/check-auth', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.authenticated) {
                    authButtons.innerHTML = `
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                ${data.user.first_name} ${data.user.last_name}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#" onclick="handleLogout()">Logout</a>
                            </div>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    `;
                } else {
                    authButtons.innerHTML = `
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    `;
                }
            });
        }
    });

    function handleLogout() {
        fetch('{{ route('logout') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: new FormData(document.getElementById('logout-form'))
        })
        .then(response => {
            if (response.ok) {
                // Refresh the page or redirect to home
                window.location.href = '{{ route('home') }}';
            }
        })
        .catch(error => console.error('Error during logout:', error));
    }
</script>

</body>

</html>
