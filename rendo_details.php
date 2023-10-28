<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "db_connect.php";

if (isset($_GET['id'])) {
    $rendo_id = $_GET['id'];

    $sql = "SELECT rendos.*, AVG(rendo_ratings.rating) as average_rating FROM rendos LEFT JOIN rendo_ratings ON rendos.id = rendo_ratings.rendo_id WHERE rendos.id = ? GROUP BY rendos.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rendo_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rendo = $result->fetch_assoc();
    } else {
        echo "Randonnée non trouvée.";
        exit();
    }
} else {
    echo "ID de randonnée manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($rendo['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <section class="rendo-details">
            <h2><?php echo htmlspecialchars($rendo['name']); ?></h2>            
            <img src="<?php echo htmlspecialchars($rendo['image_url']); ?>" alt="<?php echo htmlspecialchars($rendo['name']); ?> class="rendo-photo">            
            <div class="rendo-info">
                <div class="rendo-description">
                    <h3>Description :</h3> 
                    <p><?php echo nl2br(htmlspecialchars($rendo['description'])); ?></p>
                </div>
                <div class="rendo-address">
                    <h3>Adresse du point de départ :</h3>
                    <p><?php echo htmlspecialchars($rendo['start_address']); ?></p>
                </div>
                <h3>Notez cette randonnée :</h3>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <p><a href="login.php">Connectez-vous</a> pour noter cette randonnée.</p>       
                <?php else: ?>
                    <form action="submit_rating.php" method="post">
                        <input type="hidden" name="rendo_id" value="<?php echo htmlspecialchars($rendo_id); ?>">
                        <div class="rating-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" />                               
                                <label for="star<?php echo $i; ?>"></label>
                            <?php endfor; ?>
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                <?php endif; ?>
                <h3>Score de popularité :</h3>
                <p><?php echo round($rendo['average_rating'], 1); ?>/5</p>
                </div>

        </section>
    </main>

    <script src="scripts.js"></script>
</body>
</html>
