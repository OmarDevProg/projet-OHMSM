<?php
include 'connect.php';
$db = new Dbf();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $produit = $db->select("SELECT * FROM produits WHERE id = ?", [$id])[0];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $code_barre = $_POST['code_barre'];
    $reference = $_POST['reference'];
    $discount = $_POST['discount'];
    $brand = $_POST['brand'];
    $categorie = $_POST['categorie'];
    $gamme = $_POST['gamme'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $prix_unitaire_ht = $_POST['prix_unitaire_ht'];
    $prix_unitaire_ttc = $_POST['prix_unitaire_ttc'];
    $tva = $_POST['tva'];
    $prix_dachat = $_POST['prix_dachat'];
    $marge = $_POST['marge_beneficier'];

    $image_path = null;

    // Vérifie si une image est envoyée
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../public/images/';
        $public_path = '/images/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $unique_name = uniqid() . '_' . basename($_FILES['image_upload']['name']);
        $full_path = $upload_dir . $unique_name;

        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $full_path)) {
            // Enregistrer seulement le chemin public en base
            $image_path = $public_path . $unique_name;

            // Supprimer l’ancienne image
            $oldImage = $db->select("SELECT image_path FROM produits WHERE id = ?", [$id])[0]['image_path'];
            if ($oldImage) {
                $oldFile = '../public' . $oldImage;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
        }
    }

    // Préparer la requête SQL
    $sql = "UPDATE produits SET title = ?, code_barre = ?, reference = ?, discount = ?, brand = ?, categorie = ?, gamme = ?, quantity = ?,subcategorie = ?, prix_unitaire_ht = ?, prix_unitaire_ttc = ?, tva = ?, prix_dachat = ?, marge_beneficier = ?";
    $params = [$title, $code_barre, $reference, $discount, $brand, $categorie, $gamme, $quantity,$description, $prix_unitaire_ht, $prix_unitaire_ttc, $tva, $prix_dachat, $marge];

    if ($image_path) {
        $sql .= ", image_path = ?";
        $params[] = $image_path;
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    try {
        $stmt = $db->conF->prepare($sql);
        $stmt->execute($params);
        header("Location: listeProducts.php?updated");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
