<?php
$resultado = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor = (float)$_POST['valor'];
    $figura = $_POST['figura'];

    if ($figura == 'Karratu') {
        $area = $valor * $valor;
        $resultado = "Karratuaren azalera: " . $area . " unitate karratu.";
    } elseif ($figura == 'Zirkulu') {
        $area = pi() * $valor * $valor;
        $resultado = "Zirkuluaren azalera: " . number_format($area, 2) . " unitate karratu.";
    } else {
        $resultado = "Figuraren aukera ez da zuzena.";
    }
}
?>

<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Irudien Azalera Kalkulatu</title>
</head>

<body>
    <h1>Irudien Azalera Kalkulatu</h1>
    <form method="POST" action="">
        <label for="valor">Aldea/Erradioa:</label>
        <input type="number" id="valor" name="valor" step="0.01" required>
        <br>
        <label for="figura">Irudia:</label>
        <select id="figura" name="figura" required>
            <option value="Karratu">Karratu</option>
            <option value="Zirkulu">Zirkulu</option>
        </select>
        <br>
        <button type="submit">Kalkulatu</button>
    </form>

    <?php if (!empty($resultado)) : ?>
        <h2>Emaitza:</h2>
        <p><?= $resultado ?></p>
    <?php endif; ?>
</body>

</html>