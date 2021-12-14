<?php
require_once ('conf.php');
global $yhendus;
// punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask = $yhendus -> prepare("update konkurss set punktid = punktid + 1 where id=?");
    $kask -> bind_param("i", $_REQUEST['punkt']);
    $kask -> execute();

    header("Location: $_SERVER[PHP_SELF]");
}
// uue kommentaari lisamine
if(isset($_REQUEST['uus_komment'])) {
    $kask = $yhendus->prepare("update konkurss set kommentaar = CONCAT(kommentaar, ?) where id=?");
    $kommentlisa = $_REQUEST['komment']."\n";
    $kask->bind_param("si", $kommentlisa, $_REQUEST['uus_komment']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurss</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<ul>
    <li><a class="active_2" href="konkurss.php">Kasutaja leht</a></li>
    <li><a class="active_2" href="https://github.com/ArtemStryzhakov/Konkurs">GitHub</a></li>
</ul>
<h1>FotoKonkurss "Simple animal"</h1>
<?php
// tabeli konkurss sinu näitamine
$kask = $yhendus -> prepare("select id, nimi, pilt, kommentaar, punktid from konkurss where avalik = 1");
$kask -> bind_result($id, $nimi, $pilt, $kommentaar, $punktid);
$kask->execute();

echo "<table>";
echo "<tr>
<th>Nimi</th>
<th>Pilt</th>
<th>Kommentaarid</th>
<th>Lisa kommentaar</th>
<th>Punktid</th>
</tr>";
//fetch() - извлечение данных из набора данных
while ($kask->fetch()) {
    echo "<tr>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>".nl2br($kommentaar)."</td>";
    echo "<td>
    <form action='?'>
        <input type='hidden' name='uus_komment' value='$id';>
        <input type='text' name='komment'>
        <input type='submit' value='OK'>
    </form>
    </td>";
    echo "<td style='width: 40px'>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1 punkt</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";

?>
</body>
</html>
