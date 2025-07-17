<?php

// Connexion à la base de données
require_once 'connect.php'; // <-- adapte si besoin

if (!isset($_GET['id'])) {
    die("ID du ticket manquant.");
}

$db = new Dbf();
$ticketId = $_GET['id'];

// Récupérer les infos du ticket
$ticket = $db->select("SELECT * FROM tickets WHERE id = ?", [$ticketId]);

// Récupérer les détails du ticket
$details = $db->select("SELECT * FROM ticket_details WHERE ticket_id = ?", [$ticketId]);

if (empty($ticket) || empty($details)) {
    die("Ticket introuvable.");
}

$ticket = $ticket[0]; // extraire le seul ticket récupéré
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax):
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Ticket #<?= htmlspecialchars($ticket['id']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 80mm;
            margin: 0 auto;
        }
        h2, p {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 4px;
            border-bottom: 1px dashed #ccc;
            text-align: left;
        }
        .totaux {
            font-weight: bold;
            text-align: right;
        }
        .print-button {
            margin: 20px auto;
            display: block;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body >
<?php endif; ?>

<div id="ticketContent" >
<div style="text-align: center; margin-bottom: 10px;">
    <img src="logo.png" alt="Logo" style="width: 140px; max-height: 80px;">
</div>

<h4 style="margin: 5px 0;">Ticket de Vente</h4>

    <p>Ticket #: <?= htmlspecialchars($ticket['id']) ?><br>
       Date: <?= date('d-m-Y H:i', strtotime($ticket['date'])) ?></p>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Qté</th>
            <th>PU</th>
            <th>Remise</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($details as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['produit']) ?></td>
                <td><?= $item['quantite'] ?></td>
                <td><?= number_format($item['prix_unitaire'], 3) ?> TND</td>
                <td><?= $item['remise'] ?>%</td>
                <td><?= number_format($item['prix_total'], 3) ?> TND</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p class="totaux">Total à payer : <?= number_format($ticket['total'], 3) ?> TND</p>
</div>
    <button class="print-button" onclick="printOnlyTicket()">🖨️ imprimer</button>

</body>
<script>
    function printOnlyTicket() {
        const ticketContent = document.getElementById('ticketModalContent').innerHTML;

        const printWindow = window.open();
        printWindow.document.write(`
        <html>
        <head>
            <title>Impression Ticket</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    width: 80mm;
                    margin: 0 auto;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 14px;
                }
                th, td {
                    padding: 4px;
                    border-bottom: 1px dashed #ccc;
                    text-align: left;
                }
                .totaux {
                    font-weight: bold;
                    text-align: right;
                }
            </style>
        </head>
        <body onload="window.print(); window.close();">
        </body>
        </html>
    `);
        printWindow.document.close();
    }
</script>

</html>
