<?php
// Inclure la configuration de la base de données
include 'connect.php';
$db = new Dbf();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST["title"];
    $code_barre = $_POST["code_barre"];
    $reference = $_POST["reference"];
    $discount = $_POST["discount"];
    $brand = $_POST["brand"];
    $categorie = $_POST["categorie"];
    $gamme = $_POST["gamme"];
    $quantity = $_POST["quantity"];
    $description=$_POST["description"];

    $tva = $_POST["tva"];
    $prix_dachat = $_POST["prix_dachat"];
    $marge_beneficier = $_POST["marge_beneficier"];

    // Initialiser le chemin de l'image
    $image_path = '';

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0) {
        // Répertoire absolu sur le serveur (pour le stockage)
        $upload_dir = '../public/images/';
        // URL de base publique (pour affichage dans le navigateur)
        $public_base_url = '/images/';

        // Créer le répertoire s'il n'existe pas
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Nom unique pour l'image
        $unique_name = uniqid() . '_' . basename($_FILES['image_upload']['name']);
        $server_path = $upload_dir . $unique_name;

        // Déplacement du fichier
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $server_path)) {
            // Chemin public enregistré dans la BDD
            $image_path = $public_base_url . $unique_name;
        }
    }

    // Calcul des prix
    $prix_unitaire_ht = $prix_dachat * (1 + ($marge_beneficier / 100));
    $prix_unitaire_ttc = $prix_unitaire_ht * (1 + ($tva / 100));

    // Préparer la requête SQL
    $sql = "INSERT INTO produits (title, code_barre, reference, discount, brand, categorie, gamme, quantity,subcategorie, tva, prix_dachat, marge_beneficier, prix_unitaire_ht, prix_unitaire_ttc, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    try {
        // Exécution
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([
            $title, $code_barre, $reference, $discount, $brand, $categorie, $gamme,
            $quantity,$description, $tva, $prix_dachat, $marge_beneficier,
            $prix_unitaire_ht, $prix_unitaire_ttc, $image_path
        ]);

        // Redirection après succès
        header("Location: formProduit.php?addP");
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    } catch (Exception $e) {
        echo "General error: " . $e->getMessage();
        header("Location: formProduit.php?error=upload");
        exit();
    }
}
?>
