<?php
// Include database connection
include('connect.php'); // Make sure to replace with your actual DB connection script
$db = new Dbf();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the client ID
    $client_id = $_POST['client_id'];

    // Prepare the SQL statement to insert the facture (invoice)

  try {
      $stmt = $db->prepare("INSERT INTO facture (client_id, date_facture, montant_total, statut) VALUES (?, NOW(), ?, 'impayée')");
      $stmt->execute([$client_id, 0]); // Initially, total is set to 0

      // Get the last inserted facture ID
      $facture_id = $db->conF->lastInsertId();

      // Retrieve product IDs, quantities, and discounts
      $produit_ids = $_POST['produit_id'];
      $quantites = $_POST['quantite'];
      $remises = $_POST['remise'];

      $montant_total = 0; // Total amount of the facture

      foreach ($produit_ids as $index => $produit_id) {
          $quantite = $quantites[$index];
          $remise = $remises[$index];
          // Fetch the product price (either prix_unitaire_ht or prix_unitaire_ttc)
          $stmt_prod = $db->prepare("SELECT * FROM produits WHERE id = ?");
          $stmt_prod->execute([$produit_id]);
          $produit = $stmt_prod->fetch();

          if ($produit) {
              $prix_unitaire = $produit['prix_unitaire_ht']; // Use prix_unitaire_ht instead of price

              // Calculate the total price for the product
              $prix_total = $prix_unitaire * $quantite;
              $prix_total -= ($prix_total * $remise / 100); // Apply the discount

              $prix_total_ttc = $prix_total + ($prix_total * 0.19);
              // Insert the product into facture_articles
              $stmt_article = $db->prepare("INSERT INTO facture_articles (facture_id, produit_id, quantite, prix, prix_total_ht,prix_total_ttc,remiseParFacture) VALUES (?, ?, ?, ?,?,?,?)");
              $stmt_article->execute([$facture_id, $produit_id, $quantite, $prix_unitaire, $prix_total, $prix_total_ttc,$remise]);

              // Add the product total to the invoice total

          }
      }

      // Update the facture total amount
      $stmt_update = $db->prepare("UPDATE facture SET montant_total = ? WHERE id = ?");
      $stmt_update->execute([$montant_total, $facture_id]);

      $montant_total += $prix_total;
      header("Location: afficherFacture.php?facture_id=" . $facture_id);
      exit();

  }
  catch(PDOException $e)
  {
      $errorMessage = $e->getMessage();
      echo "Error: " . $errorMessage;  // Output error for debugging
      header("Location: formFacture.php?error=email");
      exit();
  }
}
?>
