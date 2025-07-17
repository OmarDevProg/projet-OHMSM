<?php
if (isset($_GET['id'])) {
    $ticketId = $_GET['id'];

    include 'connect.php'; // Inclure la classe Dbf

    $db = new Dbf(); // Créer une instance

    // Étape 1 : récupérer les produits du ticket
    $stmt = $db->prepare("SELECT code_barre, quantite FROM ticket_details WHERE ticket_id = ?");
    $stmt->execute([$ticketId]);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Étape 2 : pour chaque produit, ajouter la quantité supprimée au stock
    foreach ($produits as $produit) {
        $code_barre = $produit['code_barre'];
        $quantite = $produit['quantite'];

        // Ajouter la quantité à la table des produits
        $update = $db->prepare("UPDATE produits SET quantity = quantity + ? WHERE code_barre = ?");
        $update->execute([$quantite, $code_barre]);
    }


    // Étape 4 : supprimer le ticket lui-même
    $deleteTicket = $db->prepare("DELETE FROM tickets WHERE id  = ?");
    $deleteTicket->execute([$ticketId]);

    // Redirection
    header("Location: historique_ticket.php?deleted=1");
    exit;
}
?>
