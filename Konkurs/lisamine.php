<?php
// nimi lisamine konkurssi
global $yhendus;

if(!empty($_REQUEST['nimi'])){
$kask = $yhendus -> prepare("insert into konkurss(nimi, pilt, lisamisaeg) values(?, ?, NOW())");
$kask -> bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
$kask -> execute();

header("Location: $_SERVER[PHP_SELF]");
}
?>
<html>
<head>
    <title>Lisa</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<ul>
    <li><a class="active" href="haldus.php">Administreerimise leht</a></li>
    <li><a class="active_2" href="konkurss.php">Kasutaja leht</a></li>
    <li><a class="active_2" href="https://github.com/ArtemStryzhakov/Konkurs">GitHub</a></li>
    <br>
</ul>

<h2>Uue pilti lisamine konkurssi</h2>

<form action="?">
    <input type="text" name="nimi" placeholder="uus nimi"><br>
    <textarea name="pilt">pildi linki aadress</textarea><br>
    <input type="submit" value="Lisa">

</form>
</body>
</html>




