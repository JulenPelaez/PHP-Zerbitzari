<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Txanpon bihurgailua</title>
</head>
<body>
    <h1>Txanpon bihurgailua</h1>

    <?php
    $resultado = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $euros = $_POST['euros'];
        $moneda = $_POST['moneda'];

        $tasak = [
            "usd" => 1.08, 
            "gbp" => 0.83,  
            "jpy" => 164.3,
            "chf" => 0.94
        ];

        if (isset($tasak[$moneda])) {
            $bihurtua = $euros * $tasak[$moneda];
            $monedaIzena = [
                "usd" => "dólar amerikarra",
                "gbp" => "libera britaniarra",
                "jpy" => "yen japoniarra",
                "chf" => "franko suitzarra"
            ];
            $resultado = number_format($bihurtua, 2) . " " . $monedaIzena[$moneda] . " dira.";
        } else {
            $resultado = "Moneda ez da zuzena.";
        }
    }
    ?>

    <form action="" method="post">
        <label for="euros">Euro kopurua:</label>
        <input type="number" id="euros" name="euros" step="0.01" required>
        <label for="moneda">Aldatu:</label>
        <select id="moneda" name="moneda">
            <option value="usd">Dólar Amerikarra (1€ = 1.08)</option>
            <option value="gbp">Libera Britaniarra (1€ = 0.83)</option>
            <option value="jpy">Yen Japoniarra (1€ = 164.3)</option>
            <option value="chf">Franko Suitzarra (1€ = 0.94)</option>
        </select>
        <button type="submit">Bidali</button>
    </form>

    <?php if (!empty($resultado)): ?>
        <h2>Emaitza</h2>
        <p>Euros: <?= htmlspecialchars($_POST['euros']) ?>, <?= $resultado ?></p>
    <?php endif; ?>

</body>
</html>
