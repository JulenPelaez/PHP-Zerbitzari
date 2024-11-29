<!DOCTYPE html>
<html>
<head>
    <title>Faktoriala kalkulatu</title>
</head>
<body>
    <h1>Faktoriala kalkulatu</h1>
    <form method="POST">
        <label for="zenbakia">Sartu zenbaki bat:</label>
        <input type="number" name="zenbakia" id="zenbakia" required>
        <button type="submit">Kalkulatu</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $zenbakia = intval($_POST["zenbakia"]);
        $faktoriala = 1;

        for ($i = 1; $i <= $zenbakia; $i++) {
            $faktoriala *= $i;
        }

        echo "<p>Zenbakia: $zenbakia</p>";
        echo "<p>Faktoriala: $faktoriala</p>";
    }
    ?>
</body>
</html>
