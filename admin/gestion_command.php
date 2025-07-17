<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; // Stop the script if the user is not logged in
}
?>
<?php
include 'connect.php'; // Include your Dbf class

$db = new Dbf(); // Instantiate the class


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Buttons Extension CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icon-1.11.3" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/datatables.min.css">




    <style>
        .toast-success {
            background-color: #28a745 !important;
            /* Green background */
            color: #ffffff !important;
            /* White text */
            border-radius: 10px !important;
            /* Rounded corners */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1) !important;
            /* Subtle shadow */
        }

        .toast-success .toast-title {
            font-weight: bold;
            font-size: 16px;
        }

        .toast-success .toast-message {
            font-size: 14px;
        }

        .toast-close-button {
            color: #ffffff !important;
            /* Close button color */
            opacity: 1 !important;
            /* Full opacity */
        }

        .toast-progress {
            background-color: #ffffff !important;
            /* Progress bar color */
        }


        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Roboto', sans-serif;
        }

        /* Table Header */
        .table thead {
            background-color: #343a40;
            color: white;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table thead th {
            padding: 12px;
            border-bottom: 2px solid #dee2e6;
            font-size: 1rem;
        }

        /* Table Rows */
        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Table Cells */
        .table tbody td {
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            color: #495057;
            vertical-align: middle;
        }

        /* Action Buttons */
        .table tbody td button,
        .table tbody td a {
            padding: 6px 10px;
            font-size: 0.85rem;
            border-radius: 4px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Roboto', sans-serif;
        }

        /* Table Header */
        .table thead {
            background-color: #d5d8da;
            color: white;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table thead th {
            padding: 12px;
            border-bottom: 2px solid #dee2e6;
            font-size: 1rem;
        }

        /* Table Rows */
        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Table Cells */
        .table tbody td {
            padding: 10px;
            text-align: left;
            font-size: 0.9rem;
            color: #495057;
            vertical-align: middle;
        }

        /* Action Buttons */
        .table tbody td button,
        .table tbody td a {
            padding: 6px 10px;
            font-size: 0.85rem;
            border-radius: 4px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .table {
                font-size: 0.85rem;
            }
            .table thead th, .table tbody td {
                padding: 8px;
            }
        }



        .dt-button.btn-print {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Light blue for print button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-print:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-pdf {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Red for PDF button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-pdf:hover {
            background-color: #c2c2c2;
        }

        .btn-dropdown {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Yellow for Excel button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-excel {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Yellow for Excel button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-excel:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-csv {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Green for CSV button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-csv:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-copy {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Blue for Copy button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-copy:hover {
            background-color: #c2c2c2;
        }

        .card-body {
            max-width: 100%;
            overflow-x: auto;
        }

        /* Styling for Hide/Show Button */
        .dropdown-button {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            background-color: #ff6f61;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dropdown-button:hover {
            background-color: #e63e50;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 850px;
            top: 0px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            border-radius: 5px;
            z-index: 1;
            width: 200px;
            padding: 10px 0;
            text-align: left;
        }

        .dropdown-content a {
            display: block;
            color: #495057;
            padding: 8px 12px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dropdown-content a:hover {
            background-color: #f8f9fa;
            /* Light gray background on hover */
        }


        .dropdown-button {
            background-color: #4CAF50;
            /* Green background for the button */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown-button:hover {
            background-color: #3e8e41;
        }

        .dropdown-content.show {
            display: block;
            /* Show the dropdown when toggled */
        }

        /* Styling for DataTables search input */
        .dataTables_filter {
            float: right;
            /* Position it to the right of the table */
            margin-bottom: 20px;
        }

        .dataTables_filter input {
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            color: #495057;
            width: 200px;
            /* Adjust the width of the input */
            transition: all 0.3s ease;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: #007bff;
            /* Highlight the border on focus */
            background-color: #fff;
        }

        .dataTables_filter label {
            margin-right: 10px;
            /* Space between the label and input */
            font-weight: 600;
            color: #495057;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .dataTables_filter input {
                width: 100%;
                /* Make the search input field full width on smaller screens */
                font-size: 0.8rem;
            }
        }

        /* Date Filter Styling */
        /* General styling for date input fields */
        /* Adjust spacing and alignments for the layout */
        .d-flex {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Adjust spacing between input and button */
        }

        .d-flex gap-4 {
            gap: 20px;
        }

        /* Input fields styling */
        .form-control {
            border-radius: 15px;
            background-color: #f7f7f7;
            border: 2px solid #007bff;
            font-size: 16px;
        }

        /* Add shadow and highlight focus state for the inputs */
        .form-control:focus {
            border-color: #f39c12;
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.6);
        }

        /* Customize the icon color */
        .input-group-text i {
            font-size: 18px;
            color: #f39c12;
        }

        /* Button style */
        /* Button style adjustments for smaller size */
        /* Button style adjustments for smaller size */
        .btn-primary {
            position: relative;
            /* top: 25px; */

            background-color: #1048e3;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            /* Smaller font size */
            padding: 6px 12px;
            /* Reduced padding for smaller size */
        }

        .haroun {
            position: relative;
            top: 25px;

            background-color: #1048e3;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            /* Smaller font size */
            padding: 6px 12px;
            /* Reduced padding for smaller size */
        }


        .btn-primary:hover {
            background-color: #c0392b;
        }

        .btn-primary i {
            font-size: 16px;
            /* Smaller icon size */
        }

        /* Adjust spacing between the icon and text */
        .btn span {
            font-size: 14px;
            /* Smaller text size */
            margin-left: 5px;


        }

        input[type="date"] {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* Label for a more professional look */
        .form-label {
            margin-bottom: 8px;
        }


        /* General Pagination Styling */
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: center;
            /* Center-align pagination */
            align-items: center;
            gap: 8px;
            /* Space between pagination buttons */
            margin-top: 20px;
            /* Space above pagination */
            font-family: 'Roboto', sans-serif;
            /* Clean modern font */
        }

        /* Pagination Buttons Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px;
            /* Button padding */
            margin: 0 2px;
            /* Small margin between buttons */
            font-size: 14px;
            /* Font size */
            color: #007bff;
            /* Blue text for buttons */
            border: 1px solid #ced4da;
            /* Light border */
            background-color: #ffffff;
            /* White background */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth hover effects */
            text-decoration: none;
            /* Remove underline */
        }

        /* Hover Effect */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
            /* Blue border on hover */
            background-color: #f8f9fa;
            /* Light gray background on hover */
        }

        /* Active Pagination Button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            /* Blue background */
            color: #ffffff !important;
            /* White text */
            border-color: #007bff;
            /* Blue border */
            font-weight: bold;
            /* Highlight active button */
            cursor: default;
            /* No pointer on active button */
        }

        /* Disabled Pagination Buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: #adb5bd;
            /* Gray text for disabled */
            border-color: #dee2e6;
            /* Neutral border */
            background-color: #e9ecef;
            /* Light gray background */
            cursor: not-allowed;
            /* No pointer for disabled */
        }

        /* << and >> Buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.first,
        .dataTables_wrapper .dataTables_paginate .paginate_button.last {
            font-weight: bold;
            /* Make << and >> prominent */
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_paginate {
                flex-wrap: wrap;
                /* Wrap buttons on smaller screens */
                gap: 4px;
                /* Smaller gap */
            }
        }
    </style>
    <title>
        SEASIDECARE
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>

<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-dark position-absolute w-100"></div>


<aside fragment="navbar" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <div class="d-flex justify-content-center align-items-center" style="height: 150px;">
            <a class="navbar-brand" href="#" target="_blank">
                <img src="logo.png" alt="main_logo" class="img-fluid" style="max-width: 200px; height: auto;">
            </a>
        </div>
    </div>
    </br></br>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Acceuil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuUtilisateur" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestion des produits</span>
                </a>

                <div class="collapse" id="submenuUtilisateur">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="formProduit.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter un produit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeProducts.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des produits
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link  " href="formProduitT.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-edit" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gérer sections</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuClients" role="button" aria-expanded="false" aria-controls="submenuClients">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-line" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestion des clients</span>
                </a>

                <div class="collapse" id="submenuClients">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="formClient.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter Client
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeClient.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des Clients
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#submenuFacture" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">gestion des factures</span>
                </a>

                <div class="collapse" id="submenuFacture">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="formFacture.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter facture
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeFacture.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des des factures
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="scanner_produit.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-hand-holding-dollar" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Vente au comptoire</span>
                </a>

            </li>
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['user_job'] == 'admin') {
                echo '
    <a href="historique_ticket.php" class="px-4 py-3 flex items-center text-gray-600 hover:text-purple-600 hover:bg-purple-50 text-decoration-none">
        <i class="fa-solid fa-box-archive mr-3"></i>
        <span>Historique de ticket</span>
    </a>';
            }
            ?>

            <li class="nav-item ">
                <a class="nav-link" href="avoire.php">
                    <i class="fa-solid fa-share-from-square"></i>
                    avoirs de ticket
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link dropdown-toggle bg-gradient-success"href="gestion_command.php">
                    <i class="fa-solid fa-receipt"></i>
                    liste commande
                </a>
            </li>



            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">gestion de compte</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="profile.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Espace Comptes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="logout.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Se déconnecter</span>
                </a>
            </li>

        </ul>
    </div>

</aside>
<main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Gestion des commandes</li>
                </ol>
                <h6 class="font-weight-bolder text-white mb-0">commandes</h6>
            </nav>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                    </div>
                </a>
                           
            </li>

    </nav>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- End Navbar -->


    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>




    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header text-white px-4 py-3">
                        <h6 class="mb-0">Liste des commandes</h6>
                    </div>
                    <div class="card-body p-4">
                        <table id="commandesTable" class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produits</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $commandes = $db->select("select * from orders");

                            foreach ($commandes as $commande):
                                $produits = json_decode($commande['items'], true);
                                $client = json_decode($commande['customer'], true);
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($commande['id']) ?></td>
                                    <td><?= htmlspecialchars($commande['created_at']) ?></td>
                                    <td>
                                        <ul>
                                            <?php foreach ($produits as $produit): ?>
                                                <li><?= htmlspecialchars($produit['title']) ?> - <?= $produit['quantity'] ?> × <?= number_format($produit['price'], 3) ?> DT</li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td><?= number_format($commande['total'], 2) ?> DT</td>
                                    <td>
                                        <?= htmlspecialchars($client['firstName'] . ' ' . $client['lastName']) ?><br>
                                        <?= htmlspecialchars($client['email']) ?><br>
                                        <?= htmlspecialchars($client['city']) ?>, <?= htmlspecialchars($client['country']) ?><br>
                                        📞 <?= htmlspecialchars($client['phoneNumber']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($commande['statut']) ?></td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-sm btn-success btn-valider me-1" data-id="<?= $commande['id'] ?>">
                                            <i class="fas fa-check-circle me-1"></i>Valider
                                        </button>
                                        <button class="btn btn-sm btn-danger btn-refuser" data-id="<?= $commande['id'] ?>">
                                            <i class="fas fa-times-circle me-1"></i>Refuser
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        const table = $('#commandesTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            }
        });

        // Bouton VALIDER
        $('.btn-valider').click(function () {
            const button = $(this);
            const id = button.data('id');
            const row = button.closest('tr');

            Swal.fire({
                title: 'Confirmer la validation ?',
                text: "Commande #" + id,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, valider',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('valider_commande.php', { id: id, action: 'valider' }, function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Validée',
                            text: 'Commande validée avec succès',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Supprimer la ligne du tableau
                        table.row(row).remove().draw();
                    });
                }
            });
        });

        // Bouton REFUSER
        $('.btn-refuser').click(function () {
            const button = $(this);
            const id = button.data('id');
            const row = button.closest('tr');

            Swal.fire({
                title: 'Refuser cette commande ?',
                text: "Commande #" + id,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, refuser',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('valider_commande.php', { id: id, action: 'refuser' }, function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Refusée',
                            text: 'Commande refusée',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Supprimer la ligne du tableau
                        table.row(row).remove().draw();
                    });
                }
            });
        });
    });
</script>
<!-- SweetAlert2 CSS/JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_GET['rep'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rep = "<?= addslashes($_GET['rep']) ?>";
            let icon = 'info';
            let title = 'Info';

            if (rep === 'validee') {
                icon = 'success';
                title = 'Commande validée';
            } else if (rep === 'refusee') {
                icon = 'error';
                title = 'Commande refusée';
            } else {
                icon = 'warning';
                title = 'Action inconnue';
            }

            Swal.fire({
                icon: icon,
                title: title,
                text: rep
            });
        });
    </script>
<?php endif; ?>



<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>


<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- DataTables Buttons extension JS -->

<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>

<!-- jEditable -->
<script src="https://cdn.jsdelivr.net/npm/jquery-jeditable@2.0.17/dist/jquery.jeditable.min.js"></script>

<!-- Additional CSS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB9OBQTxk+d6jaIV0SDbzl4gipFb38B8ANaK8nyE5DAurrTi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-qN6AoGP6nhCCTAVTtXkCHykaOxd+WjJCFq0t/sXUuFtF0h7x1zwE0H8up2zWbiA/" crossorigin="anonymous"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
