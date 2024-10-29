<?php

$weight = isset($_POST['gewicht']) ? str_replace(',', '.', $_POST['gewicht']) : 0;
$height = isset($_POST['groesse']) ? str_replace(',', '.', $_POST['groesse']) : 0;

if (!is_numeric($weight) || !is_numeric($height) || $weight <= 0 || $height <= 0) {
    echo '<link rel="stylesheet" type="text/css" href="styles.css">';
    echo '<div class="error"><p>Bitte geben Sie gültige Werte für Gewicht und Größe ein.</p></div>';
    exit;
}

$bmi = round($weight / ($height * $height), 2);

$kategorie = '';
switch ($bmi) {
    case ($bmi < 18.5):
        $kategorie = 'Untergewicht';
        break;
    case ($bmi >= 18.5 && $bmi < 25):
        $kategorie = 'Normalgewicht';
        break;
    case ($bmi >= 25 && $bmi < 30):
        $kategorie = 'Übergewicht';
        break;
    case ($bmi >= 30 && $bmi < 35):
        $kategorie = 'Starkes Übergewicht';
        break;
}


echo '
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>BMI-RECHNER</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>BMI-RECHNER</h1>
        <p>Bitte geben Sie Ihr Gewicht und Ihre Größe ein, um Ihren BMI zu berechnen.</p>
        <form action="bmi.php" method="post">
            <input type="number" min="1" max="1000" step="0.01" name="gewicht" placeholder="Gewicht in kg" required>
            <input type="number" min="1" max="1000" step="0.01" name="groesse" placeholder="Größe in metern" required>
            <button type="submit" name="submit">Berechnen</button>
        </form>
        <h2>Dein BMI beträgt: ' . $bmi . ' ('.$kategorie.')</h2>
    </div>
<footer>
    <p class="footer">© 2024 BMI-RECHNER - Gesundheitsamt Emden</p>
</footer>
</body>
</html>
';
$file = fopen('bmi.txt', 'a');
fwrite($file,  $_SERVER['REMOTE_ADDR']." | <".date('d.m.Y H:i:s')." > $weight / ($height * $height) = $bmi ($kategorie)" . "\n");
fclose($file);

