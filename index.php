<?php
    include_once('connectiondb.php');
    $link=connectdb();
    $sql1 = "SELECT docmaster.* FROM docmaster GROUP BY docmaster.numerodoc";//da modificare
    $result=mysqli_query($link,$sql1);
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
        <label>Numero documento</label>
        <select name="numero_doc">
            <?php while ($row=mysqli_fetch_array($result)) {
                $val=$row['NumeroDoc'];
                echo "<option value=$val>$val</option>";
            }?>
        </select>
    </fieldset>

    <input type="submit" value="Salva" />
</form>

</body>
</html>