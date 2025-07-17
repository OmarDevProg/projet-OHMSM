<?php
require "connect.php";
$db = new Dbf();

$id = intval($_POST['id']);
$action = $_POST['action'];
$now = date('Y-m-d H:i:s');

if ($action === 'valider') {
    $stmt = $db->prepare("UPDATE orders SET statut = 'validée', date_validation = ? WHERE id = ?");
    $stmt->execute([$now, $id]);
    header("Location: gestion_command.php?rep=validee");
    exit;
} elseif ($action === 'refuser') {
    $stmt = $db->prepare("UPDATE orders SET statut = 'refusée', date_validation = ? WHERE id = ?");
    $stmt->execute([$now, $id]);
    header("Location: gestion_command.php?rep=refusee");
    exit;
} else {
    header("Location: gestion_command.php?rep=action_invalide");
    exit;
}
