<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="bearer-token" content="{{ session('passport_token') }}">
    <title>Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.js"></script>

<!-- DataTables Bootstrap 4/5 Integration CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap 4/5 Integration JS -->
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;

        }

        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .breadcrumb {
            background-color: white;
        }

        .content {
            margin-left: 250px;
            box-sizing: border-box;
            transition: margin-left 0.3s ease-in-out;
            flex-grow: 1;
        }

        .content.full-width {
            margin-left: 0;
        }

        footer {
            background: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .stats-card {
            flex: 1;
            padding: 20px;
            color: white;
            border-radius: 8px;
            text-align: center;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card-blue {
            background: #007bff;
        }

        .stats-card-green {
            background: #28a745;
        }

        .stats-card-yellow {
            background: #ffc107;
        }

        .stats-card-red {
            background: red;
        }

        .navbar-light {
            background-color: #f8f9fa;
            /* position: relative; */
            z-index: 1050;
            top: 0;
            position: fixed;
            /* top: 0; */
            left: 0;
            right: 0;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .navbar-light .navbar-brand {
            color: #0d6efd;
            font-weight: bold;
        }

        .navbar-light .navbar-brand:hover {
            color: #084298;
        }

        .navbar-toggler-icon {
            background-color: #007bff;
        }


        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .profile-section {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .profile-section .dropdown-menu {
            right: 0;
            left: auto;
        }
        #sidebarCollapse {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            z-index: 1050;
            cursor: pointer;
            color: black;
        }

        #sidebar .nav-link i {
            margin-right: 10px;
        }

        #sidebar .sidebar-header {
            background-color: #3b82f6;
            /* Softer blue */
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        #sidebar .nav-link {
            padding: 15px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 500;
            transition: background-color 0.3s ease, padding-left 0.2s ease;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 20px;
            /* Slight indent on hover */
        }

        #sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.3);
            /* Slightly darker for active */
        }

        #sidebar {
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            /* Professional blue gradient */
            color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
            z-index: 1040;
            padding-top: 20px;
            height: 100vh !important;
        }

        #sidebar.collapsed {
            transform: translateX(-250px);
        }

        /* Submenu Styles */
        #sidebar .collapse {
            background-color: #1e40af;
            /* Darker blue for submenu */
        }

        #sidebar .collapse .nav-link {
            padding: 12px 15px;
            color: #d1d5db;
        }

        #sidebar .collapse .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Icons */
        #sidebar .nav-link i {
            color: #e0f2fe;
        }

        #sidebar .nav-link.active i {
            color: #ffdd57;
            /* Golden color for active icon */
        }

        @media (max-width: 768px) {
            #sidebar {
                position: absolute;
                height: 100%;
                transform: translateX(-250px);
            }

            #sidebar.collapsed {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }
    </style>

</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="wrapper" style="margin-top: 3%;">
        @yield('content')
        @include('layouts.footer')
    </div>
</body>

</html>