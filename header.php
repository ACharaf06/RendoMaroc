<?php
// Vérifie si une session n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<header>
    <nav class="nav-bar">
        <a href="index.php">Accueil</a>
        <a href="contribuer.php">Contribuer</a>
        <?php if (isset($_SESSION['user_id'])) : ?>
            Bonjour <?php echo htmlspecialchars($_SESSION['username']); ?>
        <?php else : ?>
            <a href="login.php">Connexion</a>
        <?php endif; ?>
    </nav>
</header>
