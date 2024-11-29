<?php
$host = 'localhost';
$user = 'root';
$password = 'Admin123';
$dbname = 'etxebizitzak';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Errorea datu basearekin konektatzerakoan: " . $conn->connect_error);
}

$informazioa = []; // Array para guardar los datos enviados y mostrarlos después
$formulario_bidalita = false; // Variable para saber si se envió el formulario

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formulario_bidalita = true; // Marcamos que se ha enviado el formulario

    $mota = $_POST['mota'] ?? '';
    $zonaldea = $_POST['zonaldea'] ?? '';
    $helbidea = $_POST['helbidea'] ?? '';
    $logelak = $_POST['logelak'] ?? '3';
    $prezioa = $_POST['prezioa'] ?? 0;
    $tamaina = $_POST['tamaina'] ?? 0;
    $extrak = isset($_POST['extrak']) ? implode(',', $_POST['extrak']) : '';
    $oharrak = $_POST['oharrak'] ?? '';

    $irudia = '';
    if (isset($_FILES['irudia']) && $_FILES['irudia']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../Ariketa2/irudiak/';
        $fileName = basename($_FILES['irudia']['name']);
        $targetFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['irudia']['tmp_name'], $targetFilePath)) {
            $irudia = $fileName;
        } else {
            echo "Errorea irudia igotzerakoan.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO Eraikuntzak (mota, zonaldea, helbidea, logelak, prezioa, tamaina, extrak, irudia, oharrak) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdssss", $mota, $zonaldea, $helbidea, $logelak, $prezioa, $tamaina, $extrak, $irudia, $oharrak);

    if ($stmt->execute()) {
        $informazioa = [
            'mota' => $mota,
            'zonaldea' => $zonaldea,
            'helbidea' => $helbidea,
            'logelak' => $logelak,
            'prezioa' => $prezioa,
            'tamaina' => $tamaina,
            'extrak' => $extrak,
            'irudia' => $irudia,
            'oharrak' => $oharrak,
        ];
    } else {
        echo "Errorea datuak gehitzerakoan: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beste berri bat gehitu</title>
</head>
<body>
    <?php if (!$formulario_bidalita): ?>
        <h1>Beste berri bat gehitu</h1>
        <form method="POST" action="" enctype='multipart/form-data'>
            <label for="mota">Mota:</label>
            <select id="mota" name="mota" required>
                <option value="Pisua">Pisua</option>
                <option value="Txaleta">Txaleta</option>
                <option value="Etxea">Etxea</option>
            </select>
            <br><br>

            <label for="zonaldea">Zonaldea:</label>
            <select id="zonaldea" name="zonaldea" required>
                <option value="Alde zaharra">Alde zaharra</option>
                <option value="Deustu">Deustu</option>
                <option value="Atxuri">Atxuri</option>
                <option value="Miribilla">Miribilla</option>
                <option value="Basurtu">Basurtu</option>
            </select>
            <br><br>

            <label for="helbidea">Helbidea:</label>
            <input type="text" id="helbidea" name="helbidea" required>
            <br><br>

            <label for="logelak">Logelak:</label>
            <select id="logelak" name="logelak">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3" selected>3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br><br>

            <label for="prezioa">Prezioa (€):</label>
            <input type="number" id="prezioa" name="prezioa" step="0.01" required>
            <br><br>

            <label for="tamaina">Tamaina (m²):</label>
            <input type="number" id="tamaina" name="tamaina" step="0.01" required>
            <br><br>

            <label>Extrak:</label>
            <input type="checkbox" name="extrak[]" value="Igerilekua"> Igerilekua
            <input type="checkbox" name="extrak[]" value="Lorategia"> Lorategia
            <input type="checkbox" name="extrak[]" value="Garajea"> Garajea
            <br><br>

            <label for="irudia">Irudia:</label>
            <input type="file" id="irudia" name="irudia">
            <br><br>

            <label for="oharrak">Oharrak:</label>
            <textarea id="oharrak" name="oharrak"></textarea>
            <br><br>

            <button type="submit">Gehitu</button> <br><br>
            [ <a href="../Ariketa2/index.php">Zerrendara itzuli</a> ] 
        </form>
        <br>
    <?php else: ?>
        <h2>Bidalitako informazioa:</h2>
        <p><strong>Mota:</strong> <?= htmlspecialchars($informazioa['mota']) ?></p>
        <p><strong>Zonaldea:</strong> <?= htmlspecialchars($informazioa['zonaldea']) ?></p>
        <p><strong>Helbidea:</strong> <?= htmlspecialchars($informazioa['helbidea']) ?></p>
        <p><strong>Logelak:</strong> <?= htmlspecialchars($informazioa['logelak']) ?></p>
        <p><strong>Prezioa:</strong> <?= htmlspecialchars($informazioa['prezioa']) ?> €</p>
        <p><strong>Tamaina:</strong> <?= htmlspecialchars($informazioa['tamaina']) ?> m²</p>
        <p><strong>Extrak:</strong> <?= htmlspecialchars($informazioa['extrak']) ?></p>
        <?php if ($informazioa['irudia']): ?>
            <p><strong>Irudia:</strong> <img src="../Ariketa2/irudiak/<?= htmlspecialchars($informazioa['irudia']) ?>" alt="Irudia" width="200"></p>
        <?php endif; ?>
        <p><strong>Oharrak:</strong> <?= htmlspecialchars($informazioa['oharrak']) ?></p>
        <br>
        [ <a href="">Beste berri bat gehitu</a> ] 
        [ <a href="../Ariketa2/index.php">Zerrendara itzuli</a> ] 
    <?php endif; ?>
</body>
</html>
