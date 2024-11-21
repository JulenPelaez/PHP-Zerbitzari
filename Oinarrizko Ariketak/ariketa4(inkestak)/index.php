<?php
$errorMsg = "";
$view = "formulario"; 
$archivo = "data.json";
$datos = ['Bai' => 0, 'Ez' => 0];

if (file_exists($archivo)) {
    $datos = json_decode(file_get_contents($archivo), true);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $opcion = $_POST["inkesta"] ?? null;

    if (empty($opcion)) {
        $errorMsg = "Aukera bat hautatu behar duzu.";
    } else {
        if (isset($datos[$opcion])) {
            $datos[$opcion]++;
        }
        file_put_contents($archivo, json_encode($datos));

        $view = "confirmacion";
    }
}

if (isset($_GET["view"]) && $_GET["view"] === "emaitzak") {
    $view = "emaitzak";
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkesta</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
    <?php if ($view === "formulario"): ?>
        <h1>Inkesta bete</h1>

        <?php if (!empty($errorMsg)): ?>
            <p style="color: red;"><?= htmlspecialchars($errorMsg) ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <p>Ezabatzen prezioa igotzen jarraituko duela uste duzu?</p>
            <input type="radio" id="bai" name="inkesta" value="Bai">
            <label for="bai">Bai</label><br>
            <input type="radio" id="ez" name="inkesta" value="Ez">
            <label for="ez">Ez</label><br><br>
            <button type="submit">Bidali</button>
        </form>

    <?php elseif ($view === "confirmacion"): ?>
        <h1>Inkesta: Zure erantzuna gorde da</h1>
        <p>Zure erantzuna erregistratu dugu. Eskerrik asko!</p>
        <a href="?view=emaitzak">Emaitzak ikusi</a>
        <br>
        <a href="?view=formulario">Bueltatu bozkatzeko orrira</a>

    <?php elseif ($view === "emaitzak"): ?>
        <h1>Inkesta: Inkestaren emaitzak</h1>
        <div style="width:500px">
        <canvas id="inkestaGrafikoa" width="400" height="400">
        <script>
            const ctx = document.getElementById('inkestaGrafikoa').getContext('2d');
            const grafikoa = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Bai', 'Ez'],
                    datasets: [{
                        data: [<?= $datos['Bai'] ?>, <?= $datos['Ez'] ?>],
                        backgroundColor: ['#FF6384', '#36A2EB']
                    }]
                }
            });
        </script>
</div>
<p>Jasotako bozkak guztira: <?= $datos['Bai'] + $datos['Ez'] ?></p>
<a href="?view=formulario">Bueltatu bozkatzeko orrira</a>
<?php endif; ?>
</body>
</html>
