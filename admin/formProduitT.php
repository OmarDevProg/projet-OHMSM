<?php
include 'connect.php';
$db = new Dbf();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_type'])) {
        $productId = $_POST['product_id'];
        $newType = $_POST['type'];
        if ($newType === '') {
            $newType = NULL; // clear type if empty
        }
        $sql = "UPDATE produits SET type = ? WHERE id = ?";
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$newType, $productId]);
    } elseif (isset($_POST['delete_type'])) {
        $productId = $_POST['product_id'];
        // Set type to NULL to "delete" the type
        $sql = "UPDATE produits SET type = NULL WHERE id = ?";
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$productId]);
    }
    header("Location: formProduitT.php");
    exit();
}

$products = $db->select("SELECT id, title, type,image_path FROM produits");
$types = ['' => 'Aucun', 'PT' => 'PT', 'PPV' => 'PPV', 'SO' => 'SO'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
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


    <style>
        /* Centrer la notification en haut */
        .toast-top-center {
            top: 20px;
            /* Distance par rapport au haut de la fenêtre */
            left: 50%;
            transform: translateX(-50%);
        }

        /* Personnalisation supplémentaire (optionnel) */
        .toast-success {
            background-color: #28a745 !important;
            /* Couleur de fond */
            color: #fff !important;
            /* Couleur du texte */
            font-size: 16px;
            /* Taille de la police */
            border-radius: 8px;
            /* Coins arrondis */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Ombre */
        }

        .toast-error {
            background-color: #f44336 !important;
            /* Rouge vif */
            color: #fff !important;
            /* Texte blanc */
        }

        .toast-error .toast-title {
            font-weight: bold;
            color: #fff !important;
        }

        .toast-error .toast-message {
            color: #fff !important;
        }
    </style>

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
                <a class="nav-link " data-bs-toggle="collapse" href="#submenuUtilisateur" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestion des produits</span>
                </a>

                <div class="collapse" id="submenuUtilisateur">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="formProduit.php">
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
                <a class="nav-link  bg-gradient-success" href="formProduitT.php">
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
            <li class="nav-item">
                <a class="nav-link" href="historique_ticket.php">
                    <i class="fa-solid fa-box-archive" ></i>
                    historique de ticket
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="avoire.php">
                    <i class="fa-solid fa-share-from-square"></i>
                    avoirs de ticket
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="gestion_command.php">
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
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Produit</li>
                </ol>
                <h6 class="font-weight-bolder text-white mb-0">Ajouter un produit</h6>
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



        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php if (isset($_GET['addP'])): ?>

        <script>
            toastr.options = {
                "closeButton": true, // Ajoute un bouton de fermeture
                "progressBar": true, // Barre de progression pour le temps d'affichage
                "positionClass": "toast-top-center", // Centré en haut
                "showDuration": "300", // Durée d'apparition (ms)
                "hideDuration": "1000", // Durée de disparition (ms)
                "timeOut": "5000", // Temps d'affichage (ms)
                "extendedTimeOut": "1000", // Temps après interaction utilisateur
                "showEasing": "swing", // Animation d'apparition
                "hideEasing": "linear", // Animation de disparition
                "showMethod": "fadeIn", // Effet d'apparition
                "hideMethod": "fadeOut" // Effet de disparition
            };

            // Exemple de notification
            toastr.success("Le produit a été ajouté avec succès !");
        </script>


    <?php endif; ?>


    <?php if (isset($_GET['error'])): ?>

        <script>
            toastr.options = {
                "closeButton": true, // Ajoute un bouton de fermeture
                "progressBar": true, // Barre de progression pour le temps d'affichage
                "positionClass": "toast-top-center", // Centré en haut
                "showDuration": "300", // Durée d'apparition (ms)
                "hideDuration": "1000", // Durée de disparition (ms)
                "timeOut": "5000", // Temps d'affichage (ms)
                "extendedTimeOut": "1000", // Temps après interaction utilisateur
                "showEasing": "swing", // Animation d'apparition
                "hideEasing": "linear", // Animation de disparition
                "showMethod": "fadeIn", // Effet d'apparition
                "hideMethod": "fadeOut" // Effet de disparition
            };

            // Exemple de notification
            toastr.error("mail deja exist !");
        </script>
    <?php endif; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="container py-4">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Gestion des Types de Produits</h5>
            </div>
            <div class="card-body">
                <table id="produitsTable" class="table table-bordered table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <?php if (!empty($product['image_path'])): ?>
                                    <?php
                                    // Extraire juste le nom de fichier
                                    $imageFile = basename($product['image_path']);
                                    ?>
                                        <img src="../images/686e4b26d2258_685df20f6ae0f_yassine.jpeg" alt="Image" style="max-width: 60px; max-height: 60px;">
                                <?php else: ?>
                                    <span class="text-muted">Aucune image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($product['title']) ?></td>
                            <td>
                                <form method="POST" class="d-flex align-items-center" style="gap:10px;">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                    <select name="type" class="form-select form-select-sm" style="max-width:120px;" required>
                                        <?php foreach ($types as $key => $label): ?>
                                            <option value="<?= htmlspecialchars($key) ?>" <?= ($product['type'] === $key) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($label) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="update_type" class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer le type de ce produit ?');" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                    <button type="submit" name="delete_type" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#produitsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
                }
            });
        });
    </script>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Dasinformatique</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Dasinformatique</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </footer>
    </div>
</main>
<!--   Core JS Files   -->
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

</html>
<script>
    // Remove this script as it interferes with Bootstrap's functionality
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            const isShown = target.classList.contains('show');
            target.classList.toggle('show', !isShown);
        });
    });
</script>
<script>
    // JavaScript for form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="js/toastr.min.js"></script>
