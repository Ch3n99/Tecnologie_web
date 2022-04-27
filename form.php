<?php
    include_once('connectiondb.php');
    $link=connectdb();
    $sql1 = "SELECT docmaster.* FROM docmaster  ";//da modificare
    $result=mysqli_query($link,$sql1);
    $result2=mysqli_query($link,$sql1);
    $result3=mysqli_query($link,$sql1);
    $result4=mysqli_query($link,$sql1);
    mysqli_close($link);
?>
<html>
<head>
    <title>Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<h1>Svolgimento punto 1</h1>
<p>Riempi il menù a tendina</p>

<form action="sito.php" method="POST">
<fieldset>
        <label>Codice Agente</label>
        <select type="text" name="cod_agente">
            <?php 
            while ($row=mysqli_fetch_array($result)) {
                $val1=$row['CodiceAgente'];
                echo "<option value=$val1>$val1</option>";
            }
            ?>
        </select>
    </fieldset>

    <fieldset>
        <label>Numero Doc</label>
        <select name="numero_doc">
            <?php 
            while ($row=mysqli_fetch_array($result2)) {
                $val2=$row['NumeroDoc'];
                echo "<option value=$val2>$val2</option>";
            }
            ?>
        </select>
    </fieldset>
    <fieldset>
        <label>DataDoc</label>
        <select name="data_doc">
            <?php 
            while ($row=mysqli_fetch_array($result3)) {  
                $val3=$row['DataDoc'];
                echo "<option value=$val3>$val3</option>";
            }
            ?>
        </select>
        
    </fieldset>
    <fieldset>
        <label>Provenienza</label>
        <select type="text" name="provenienza">
            <?php 
            while ($row=mysqli_fetch_array($result4)) {  
                $val4=$row['Provenienza'];
                echo "<option value=$val4>$val4</option>";
            }
            ?>
        </select>
        
    </fieldset>
    <input type="submit" value="Salva" />
</form>
</body>
</html>