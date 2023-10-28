<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "db_connect.php";

$user_is_logged_in = isset($_SESSION['user_id']);

if (!isset($_POST['rendo_id']) || !isset($_POST['rating'])) {
    header("Location: index.php");
    exit();
}

if (!$user_is_logged_in) {
    header("Location: login.php");
    exit();
}

$rendo_id = $_POST['rendo_id'];
$user_id = $_SESSION['user_id'];
$rating = $_POST['rating'];

// Vérifiez si l'utilisateur a déjà voté pour cette randonnée
$sql = "SELECT * FROM rendo_ratings WHERE rendo_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rendo_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // L'utilisateur a déjà voté, mettez à jour le vote existant
    $sql = "UPDATE rendo_ratings SET rating = ? WHERE rendo_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $rating, $rendo_id, $user_id);
} else {
    // L'utilisateur n'a pas encore voté, insérez un nouveau vote
    $sql = "INSERT INTO rendo_ratings (rendo_id, user_id, rating) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $rendo_id, $user_id, $rating);
}

$stmt->execute();

header("Location: rendo_details.php?id=" . $rendo_id);
exit();
?>
