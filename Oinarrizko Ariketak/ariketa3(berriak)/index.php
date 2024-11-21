<?php
$errorMsg = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $izena = trim($_POST["izena"]);
    $testua = trim($_POST["testua"]);
    $mota = $_POST["mota"] ?? ""; 
    $fitxategia = $_FILES["fitxategia"];

    
    if (empty($izena) || empty($testua)) {
        $errorMsg = "Izena eta Testua derrigorrezkoak dira.";
    } elseif (empty($mota)) {
        $errorMsg = "Mota aukeratu behar da.";
    } elseif ($fitxategia["error"] != 0) {
        $errorMsg = "Fitxategi bat igo behar da.";
    } else {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filePath = $uploadDir . basename($fitxategia["name"]);
        if (move_uploaded_file($fitxategia["tmp_name"], $filePath)) {
            $successMsg = "Datuak ondo bidali dira.";
        } else {
            $errorMsg = "Fitxategia gordetzean errore bat gertatu da.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berri bat gehitu</title>
</head>
<body>
    <h1>Berri bat gehitu</h1>

    <?php if (!empty($errorMsg)): ?>
        <p style="color: red;"><?= htmlspecialchars($errorMsg) ?></p>
    <?php endif; ?>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errorMsg)): ?>
        <h2>Formularioaren emaitza</h2>
        <p><strong>Izena:</strong> <?= htmlspecialchars($izena) ?></p>
        <p><strong>Testua:</strong> <?= htmlspecialchars($testua) ?></p>
        <p><strong>Mota:</strong> <?= htmlspecialchars($mota) ?></p>
        <p><strong>Fitxategiaren Izenburua:</strong> <?= htmlspecialchars($fitxategia["name"]) ?></p>
        <p><strong>Deskargatzeko esteka:</strong> <a href="ariketa3(berriak)/<?= $filePath?>" download>Deskargatu</a></p>
    <?php else: ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="izena">Izena*:</label><br>
            <input type="text" name="izena" id="izena" value="<?= htmlspecialchars($izena ?? '') ?>"><br><br>

            <label for="testua">Testua*:</label><br>
            <textarea name="testua" id="testua"><?= htmlspecialchars($testua ?? '') ?></textarea><br><br>

            <label for="mota">Mota*:</label><br>
            <select name="mota" id="mota">
                <option value="">-- Aukeratu mota --</option>
                <option value="Albistea" <?= (isset($mota) && $mota == "Albistea") ? "selected" : "" ?>>Albistea</option>
                <option value="Iritzia" <?= (isset($mota) && $mota == "Iritzia") ? "selected" : "" ?>>Iritzia</option>
                <option value="Oharra" <?= (isset($mota) && $mota == "Oharra") ? "selected" : "" ?>>Oharra</option>
            </select><br><br>

            <label for="fitxategia">Irudia*:</label><br>
            <input type="file" name="fitxategia" id="fitxategia" accept="image/*"><br><br>

            <button type="submit">Bidali</button>
        </form>
    <?php endif; ?>
</body>
</html>