<?php
include_once('connectiondb.php');
$link=connectdb();
$val1=$_POST['cod_agente'];
$val2=$_POST['numero_doc'];
$val3=$_POST['data_doc'];
$val4=$_POST['provenienza'];

$sql1 = "SELECT docnotes.* FROM docnotes WHERE docnotes.CodiceAgente='$val1' AND docnotes.NumeroDoc='$val2' AND docnotes.DataDoc ='$val3'";
$sql2= "SELECT docdetails.* FROM docdetails WHERE docnotes.NumeroDoc='$val1' AND docnotes.NumeroDoc='$val2' AND docnotes.DataDoc ='$val3'";
$result=mysqli_query($link,$sql1);
$result2=mysqli_query($link,$sql2);


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
            <td><?php echo $row['NotaOrdine']; ?></td> <td><?php echo $row['IndiceNota']; ?></td>

        </tr>
    <?php } ?>
    
</table>
<table>
    <?php while ($row=mysqli_fetch_array($result2)) { ?>
        <tr>
        <td><?php echo $row['CodiceArticolo']; ?></td> <td><?php echo $row['DescrizioneProdotto']; ?></td>

        </tr>
    <?php } ?>
    
</table>


</body>
</html>