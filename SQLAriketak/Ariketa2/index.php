<?php
$host = 'localhost';
$user = 'root';
$password = 'Admin123';
$dbname = 'etxebizitzak';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Errorea datu basearekin konektatzerakoan: " . $conn->connect_error);
}

$sql = "SELECT * FROM Eraikuntzak ORDER BY prezioa ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etxebizitzen Zerrenda</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <h1>Etxebizitzen Zerrenda</h1>
    <table>
        <thead>
            <tr>
                <th>Mota</th>
                <th>Zonaldea</th>
                <th>Logelak</th>
                <th>Prezioa (€)</th>
                <th>Tamaina (m²)</th>
                <th>Extrak</th>
                <th>Irudia</th>
                <th>Oharrak</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['mota']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['zonaldea']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['logelak']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['prezioa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tamaina']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['extrak']) . "</td>";
                    if (!empty($row['irudia'])) {
                        echo "<td><a href='irudiak/" . htmlspecialchars($row['irudia']) . "' target='_blank'><img src='irudiak/" . htmlspecialchars($row['irudia']) . "' alt='Etxebizitzaren irudia'></a></td>";
                    } else {
                        echo "<td>Irudirik ez</td>";
                    }
                    echo "<td>" . htmlspecialchars($row['oharrak']) . "</td>";
                    echo "</tr>";
                }
               
            } else {
                echo "<tr><td colspan='8'>Ez dago etxebizitzarik datu basean.</td></tr>";
            }
          

            ?>
        </tbody>
    </table>
    [ <a href="../Ariketa 3/index.php">Beste berri bat gehitu</a> ]
    <?php
    $conn->close();
    ?>
</body>
</html>
