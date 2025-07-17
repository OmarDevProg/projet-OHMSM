<?php
require('fpdf.php');
include 'db.php';

// Fetch ticket ID from URL
if (!isset($_GET['ticket_id'])) {
    echo "Ticket ID is missing!";
    exit;
}

$ticketId = $_GET['ticket_id'];

// Fetch ticket and ticket details from the database
$db = new Dbt();
$ticketQuery = "SELECT * FROM tickets WHERE id = :ticket_id";
$ticket = $db->select($ticketQuery, [':ticket_id' => $ticketId]);

if (!$ticket) {
    echo "Ticket not found!";
    exit;
}

$ticket = $ticket[0];
$ticketDetailsQuery = "SELECT * FROM ticket_details WHERE ticket_id = :ticket_id";
$ticketDetails = $db->select($ticketDetailsQuery, [':ticket_id' => $ticketId]);

// Generate PDF
class PDF extends FPDF
{
    function Header()
    {
        $this->Image('logo.png', 3, 2, 50);
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(8);
    }

    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 5, 'Qte', 0, 0, 'C');
        $this->Cell(40, 5, 'Produit', 0, 0, 'L');
        $this->Cell(12, 5, 'PU.TTC', 0, 0, 'C');
        $this->Cell(12, 5, 'PT.TTC', 0, 1, 'C');
    }

    function TableRow($quantite, $nomProduit, $prixUnitaire, $prixTotal)
    {
        $this->SetFont('Arial', '', 6);
        $this->Cell(10, 5, $quantite, 0, 0, 'C');
        $this->Cell(40, 5, substr(utf8_decode($nomProduit), 0, 38), 0, 0, 'L');
        $this->Cell(12, 5, number_format($prixUnitaire, 3) . ' ', 0, 0, 'R');
        $this->Cell(12, 5, number_format($prixTotal, 3) . ' ', 0, 1, 'R');
    }

    function Total($totalPrix)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(2);
        $this->Cell(37, 5, 'Total :', 0, 0, 'L');
        $this->Cell(36, 5, number_format($totalPrix, 3) . ' TND', 0, 1, 'R');
    }
}

$pdf = new PDF('P', 'mm', array(80, 100));
$pdf->AddPage();
$pdf->SetMargins(3, 0, 0);
$pdf->SetFont('Arial', '', 6);

$pdf->Cell(0, 10, 'Ticket de Vente', 0, 1, 'C');
$pdf->TableHeader();

$totalAmount = 0;
foreach ($ticketDetails as $detail) {
    $pdf->TableRow(
        $detail['quantite'],
        $detail['produit'],
        $detail['prix_unitaire'],
        $detail['prix_total']
    );
    $totalAmount += $detail['prix_total'];
}

$pdf->Total($totalAmount);
$pdf->Cell(80, 5, 'Date : ' . date('d/m/Y'), 0, 1);
$pdf->Cell(80, 5, 'Heure : ' . date('H:i:s'), 0, 1);
$pdf->Ln(2);
$pdf->Cell(80, 5, 'Merci de votre achat !', 0, 1);

// Save the PDF
$pdfFileName = "ticket_$ticketId.pdf";
$pdf->Output("F", $pdfFileName); // Save PDF on server

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impression du Ticket</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 50px;
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<h2>Chargement du Ticket en cours...</h2>
<div class="loader"></div>

<script>
    setTimeout(() => {
        window.open("<?php echo $pdfFileName; ?>", "_blank"); // Open PDF in a new tab
        setTimeout(() => {
            window.location.href = "scanner_produit.php"; // Redirect back
        }, 3000); // Wait 3 seconds before redirect
    }, 2000); // Simulate loading effect
</script>
</body>
</html>
