<?php
include 'biorritme.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nomusuari'];
    $data = $_POST['datanaixement'];

    $bio = new Biorritme($data, $nom);
    $valors = $bio->calculBiorritme();
    $bio->saveCalculBiorritmeToJson($valors);
} else {
    header("Location: index.html");
    exit();
}

$today = new DateTime();

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>El teu resultat de biorritme</title>
    <style>
        .progress-container { width: 100%; background-color: #e0e0e0; border-radius: 5px; margin-bottom: 20px; }
        .progress-bar { height: 30px; border-radius: 5px; text-align: center; color: white; line-height: 30px; }
        .fisic { background-color: #ff4d4d; }
        .emotiu { background-color: #33cc33; }
        .intel { background-color: #3399ff; }
        table { margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body >
    <div>    
        <h2>Resultat del biorritme</h2>
        <h1>Hola <?php echo $bio->getNom(); ?></h1>
        <p>Data actual: <?php echo $today->format('d/m/Y'); ?></p>
        <p>Data naixement: <?php echo $bio->getNaixement(); ?></p>
        <a href="index.html">Torna enrere</a>
    </div>

           
    <div>
        <h2>Biorritme físic (<?php echo $valors['físic']; ?>%)</h2>
        <div class="progress-container">
            <div class="progress-bar fisic" style="width: <?php echo $valors['físic']; ?>%"><?php echo $valors['físic']; ?>%</div>
        </div>
    </div>

    <div>
        <h2>Biorritme emotiu (<?php echo $valors['emotiu']; ?>%)</h2>
        <div class="progress-container">
            <div class="progress-bar emotiu" style="width: <?php echo $valors['emotiu']; ?>%"><?php echo $valors['emotiu']; ?>%</div>
        </div>
    </div>

    <div>
        <h2>Biorritme intel·lectual (<?php echo $valors['intelectual']; ?>%)</h2>
        <div class="progress-container">
            <div class="progress-bar intel" style="width: <?php echo $valors['intelectual']; ?>%"><?php echo $valors['intelectual']; ?>%</div>
        </div>
    </div>

    <section>
        <h2>Històric de càlculs</h2>
        <div>
            <?php echo $bio->tableCalculBiorritmeJsonFile(); ?>
        </div>
    </section>
</body>
</html>
