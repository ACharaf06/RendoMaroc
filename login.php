<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connect.php';

    $username = $_POST['username'];
    $isNewUser = isset($_POST['newUser']);

    // Vérifier si l'utilisateur existe
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($isNewUser) {
        if ($result->num_rows > 0) {
            // L'utilisateur existe déjà
            header("Location: login.php?error=2");
            exit();
        } else {
            // Créer un nouvel utilisateur
            $sql = "INSERT INTO users (username) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            
            // Récupérer l'ID de l'utilisateur nouvellement créé
            $user_id = $stmt->insert_id;
        }
    } else {
        if ($result->num_rows > 0) {
            // Récupérer l'ID de l'utilisateur existant
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    }

    // Démarrer la session et enregistrer l'ID de l'utilisateur
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;

    header('Location: index.php');

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <section class="login-section">

        <?php if (isset($_GET['error'])): ?>
            <?php if ($_GET['error'] == 1): ?>
                <p>L'identifiant renseigné n'existe pas.</p>
            <?php elseif ($_GET['error'] == 2): ?>
                <p>L'identifiant renseigné existe déjà.</p>
            <?php endif; ?>
        <?php endif; ?>

            <h2>Connexion / Inscription</h2>
            <form id="loginForm" action="login.php" method="post">
                <div class="form-group">
                    <label for="username">Identifiant :</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="newUser" name="newUser">
                    <label for="newUser">Créer un nouvel utilisateur</label>
                </div>
                <button type="submit">Valider</button>
            </form>
        </section>
    </main>

    <!-- <script src="scripts.js"></script> -->
</body>
</html>
