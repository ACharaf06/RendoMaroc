<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randos Maroc</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include "header.php"; ?>
    <?php include "db_connect.php"; ?>

    <main>
        <div class="banner">
            <h1>Welcome to RendoMaroc</h1>
        </div>

        <section class="rendos-list">
            <h2>Liste des randonnées</h2>
            <form id="sort-form" method="get">
                <label for="sort-by">Trier par :</label>
                <select id="sort-by" name="sort-by">
                    <option value="name">Nom</option>
                    <option value="average_rating">Score de popularité</option>
                </select>
                <button type="submit" style="display: none;">Trier</button>
            </form>

            <div class="rendos-container">
                <?php
                $sql = "SELECT rendos.*, AVG(rendo_ratings.rating) as average_rating FROM rendos LEFT JOIN rendo_ratings ON rendos.id = rendo_ratings.rendo_id GROUP BY rendos.id";
                
                if (isset($_GET['sort-by'])) {
                    $sort_by = $_GET['sort-by'];

                    if ($sort_by === 'name') {
                        $sql .= " ORDER BY name";
                    } else if ($sort_by === 'average_rating') {
                        $sql .= " ORDER BY average_rating DESC";
                    }
                } else {
                    $sql .= " ORDER BY name";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="rendo-preview">';
                        echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<a href="rendo_details.php?id=' . $row['id'] . '">Voir plus</a>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Aucune randonnée trouvée.</p>";
                }
                $conn->close();
                ?>
            </div>
        </section> 
    </main>

    <script src="scripts.js"></script>
</body>
</html>
