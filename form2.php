<?php
include_once('connectiondb.php');
$link=connectdb();
$sql1 = "SELECT docmaster.* FROM docmaster GROUP BY docmaster.CodiceAgente";
$result=mysqli_query($link,$sql1);

mysqli_close($link);
?>
<html>
<head>
    <title>Form</title>
</head>
<body>
<h1>Svolgimento punto 2</h1>
<p>Riempi il menù a tendina</p>

<form action="sito.php" method="POST">

    <fieldset>
        <label>Codice agente</label>
        <select name="cod_agente">
            <?php while ($row=mysqli_fetch_array($result)) {
                $val=$row['CodiceAgente'];
                echo "<option value=$val>$val</option>";
            }?>
        </select>
    </fieldset>

    <input type="submit" value="Salva" />
</form>

</body>
</html>
