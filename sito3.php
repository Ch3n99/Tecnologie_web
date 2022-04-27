<?php
include_once('connectiondb.php');
$link=connectdb();
$sql1 = "SELECT docdetails.CodiceAgente, SUM(docdetails.QuantitaOrd_1) AS Totale
            FROM docdetails 
            GROUP BY docdetails.CodiceAgente 
            ORDER BY docdetails.Totale DESC";
$result=mysqli_query($link,$sql1);
mysqli_close($link);
?>
<html>
<head>
    <title>Statistiche</title>
</head>
<title>Statistiche vendite</title>
<style>
    table {
        border: 1px solid #000000;
    }
</style>
</head>
<body>
<table>
    <?php while ($row=mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $row['CodiceAgente']; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>