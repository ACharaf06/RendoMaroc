<?php

// Vérifie si une session est déjà active, sinon démarre une nouvelle session
if (session_status() == PHP_SESSION_NONE) {
    // meme avec le if j'ai toujour une erreur quand je vais a la page 
    //contribuer alors que je suis connecter alors j'utilise le @ pour supprimer 
    //les messages d'erreur liés à session_start() et démarre la session
    //finalement c'etait un probleme de chauvauchement avec header.php auquel je fais appel plus tard dans le code et ou je cree une session aussi
    //un if dans header a resoulut le probleme
    session_start();
}

// Vérifie si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page de connexion
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connect.php';

    $name = $_POST['name'];
    $description = $_POST['description'];
    $popularity_score = $_POST['popularity_score'];
    $start_address = $_POST['start_address'];

    $image_name = $_FILES['photo']['name'];
    $image_temp = $_FILES['photo']['tmp_name'];
    $image_folder = 'uploads/';
    $image_path = $image_folder . $image_name;

    move_uploaded_file($image_temp, $image_path);

    $sql = "INSERT INTO rendos (name, description, popularity_score, start_address, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $name, $description, $popularity_score, $start_address, $image_path);

    if ($stmt->execute()) {
        $message = "Randonnée ajoutée avec succès !";
        //pour etre rediriger vers la page de la rendo nouvellemnt crée
        $new_rendo_id = $conn->insert_id;
        header("Location: rendo_details.php?id=" . $new_rendo_id);
        exit();
    } else {
        $message = "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribuer - Randos Maroc</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <?php if (isset($message)): ?>
            <div class="message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <section class="contribution-form">
            <h2>Ajouter une randonnée</h2>
            <form action="contribuer.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nom de la randonnée :</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description de la randonnée :</label>
                    <textarea id="description" name="description" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label for="popularity_score">Score de popularité :</label>
                    <input type="number" id="popularity_score" name="popularity_score" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <label for="start_address">Adresse du point de départ :</label>
                    <input type="text" id="start_address" name="start_address" required>
                </div>
                <div class="form-group">
                    <label for="photo">Photo de la randonnée :</label>
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                </div>
                <button type="submit">Ajouter la randonnée</button>
            </form>
        </section>
    </main>

   <!-- <script src="scripts.js"></script> -->
</body>
</html>
