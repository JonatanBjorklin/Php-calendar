<!DOCTYPE html>
<html>
<head>
    <title>Månadskalender</title>
    <style>
    body {
        color: whitesmoke;
        text-shadow: 2px 2px 5px black;
        background-color: rgba(70, 121, 158, 0.504);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin: 20px;
    } 

    table {
        border-collapse: collapse;                
        margin: 20px;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    .red {
        color: #d13235;
    }
    </style>
</head>
<body>

<?php
function skrivUtKalender($ar, $manad, $arNummer, $dagNummer) {
    include 'namnsdag.php';
    include 'emoji.php';
    $forsstaDag = mktime(0, 0, 0, $manad, 1, $arNummer);
    $antalDagar = date('t', $forsstaDag);
    $forsstaVeckodag = date('N', $forsstaDag);

    echo "<h2>" . date('F', $forsstaDag) . " $arNummer " . $emoji[$manad - 1] . "</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Mån</th><th>Tis</th><th>Ons</th><th>Tor</th><th>Fre</th><th>Lör</th><th class='red'>Sön</th><th>Vecka</th></tr>";
    
    $dagRaknare = 1;
    $veckaRaknare = date('W', $forsstaDag);

    for ($i = 1; $i <= 6; $i++) {
        echo "<tr>";
        for ($j = 1; $j <= 7; $j++) {
            if (($i == 1 && $j < $forsstaVeckodag) || $dagRaknare > $antalDagar) {
                echo "<td>&nbsp;</td>";
            } else {
                $namesNum = date("z", strtotime("$arNummer-$manad-$dagRaknare")) + 1;
                $name = isset($namnsdag[$namesNum]) ? $namnsdag[$namesNum][0] : '';
                $class = ($j == 7) ? "red" : "";
                $dateString = date('F j', mktime(0, 0, 0, $manad, $dagRaknare, $arNummer));
                $currentDate = strtotime("$arNummer-$manad-$dagRaknare");
                $namesDay = date('j', strtotime('third sunday of ' . date('F', $currentDate))) + 14;
                $namesDayString = date('F j', strtotime(date('Y') . '-' . date('n') . '-' . $namesDay));
                echo "<td class='$class'>$dateString <br>" . (date("z", strtotime("$arNummer-$manad-$dagRaknare")) + 1) . " $name</td>";
                $dagRaknare++;
            }

            if ($j == 1 && $i != 1) {
                $veckaRaknare++;
            }
        }

        echo "<td>";
        $currentDate = strtotime("$arNummer-$manad-$dagRaknare");
        $namesDay = date('j', strtotime('third sunday of ' . date('F', $currentDate))) + 14;
        $namesDayString = date('F j', strtotime(date('Y') . '-' . date('n') . '-'));
        echo "Vecka $veckaRaknare</td>";
        echo "</tr>";
    }

    echo "</table>";
    }

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    list($ar, $manad, $dag) = explode('-', $date);
} else {
    $ar = date('Y');
    $manad = date('n');
}

skrivUtKalender($ar, $manad, $ar, 1);
?>

<form action="#" method="get">
    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
    <input type="submit" value="Visa kalender">
</form>

<form action="#" method="get">
    <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime("$ar-$manad-01 -1 month")); ?>">
    <input type="submit" value="Föregående månad">
</form>

<form action="#" method="get">
    <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime("$ar-$manad-01 +1 month")); ?>">
    <input type="submit" value="Nästa månad">
</form>

</body>
</html>
