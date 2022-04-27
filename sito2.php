<?php
include_once('connectiondb.php');
$link=connectdb();
    $val=$_POST['cod_agente'];
    $sql1 = "SELECT docdetails.* FROM docdetails WHERE docdetails.CodiceAgente='$val'";
    $result=mysqli_query($link,$sql1);
mysqli_close($link);
?>

<html>
<head>
    <title>Risultato</title>
    <style>
        table {
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
    <h1>Risultato</h1>
    <table>
        <?php while ($row=mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $row['CodiceArticolo']; ?></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>