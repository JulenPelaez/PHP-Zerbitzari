<!DOCTYPE html>
<html>
<head>
    <title>Biderketa taulak</title>
</head>
<body>
    <h1>Biderketa taulak</h1>
    <form method="POST">
        <label for="zenbakia">Sartu zenbaki bat:</label>
        <input type="number" name="zenbakia" id="zenbakia" required>
        <button type="submit">Kalkulatu</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $zenbakia = intval($_POST["zenbakia"]);

        echo "<p>Sartu duzun zenbakia: $zenbakia</p>";
        echo "<p>Emaitza:</p>";
        echo "<ul>";

        for ($i = 1; $i <= 10; $i++) {
            $emaitza = $zenbakia * $i;
            echo "<li>$zenbakia x $i = $emaitza</li>";
        }

        echo "</ul>";
    }
    ?>
</body>
</html>
