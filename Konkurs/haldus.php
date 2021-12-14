<?php
require_once ('conf.php');
global $yhendus;

//функция, которая удаляет из адресной строки переменные
function clearVarsExcept($url, $varname){
    return strtok(basename($_SERVER['REQUEST_URI']), "?");
}

// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask = $yhendus -> prepare("update konkurss set punktid = 0 where id=?");
    $kask -> bind_param("i", $_REQUEST['punkt']);
    $kask -> execute();

    header("Location: $_SERVER[PHP_SELF]");
}

// Komment nulliks UPDATE
if(isset($_REQUEST['kommentaar'])){
    $kask = $yhendus -> prepare("update konkurss set kommentaar = ' ' where id=?");
    $kask -> bind_param("i", $_REQUEST['kommentaar']);
    $kask -> execute();

    header("Location: $_SERVER[PHP_SELF]");
}

// nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask = $yhendus -> prepare("insert into konkurss(nimi, pilt, lisamisaeg) values(?, ?, NOW())");
    $kask -> bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask -> execute();

    header("Location: $_SERVER[PHP_SELF]");
}

// nimi näitamine avalik = 1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask = $yhendus -> prepare("update konkurss set avalik = 1 where id=?");
    $kask -> bind_param("i", $_REQUEST['avamine']);
    $kask -> execute();
    header("Location: $_SERVER[PHP_SELF]");
}

// nimi peitmine avalik = 1 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask = $yhendus -> prepare("update konkurss set avalik = 0 where id=?");
    $kask -> bind_param("i", $_REQUEST['peitmine']);
    $kask -> execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//kustuta
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare('DELETE FROM konkurss WHERE id=?');
    $kask->bind_param("i",$_REQUEST['kustuta']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
?>
<!Doctype html>
<html lang="et">
<head>
    <title>Fotokonkurssi halduse leht</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<ul>
    <li><a class="active" href="haldus.php">Administreerimise leht</a></li>
    <li><a class="active_2" href="konkurss.php">Kasutaja leht</a></li>
    <li><a class="active_2" href="https://github.com/ArtemStryzhakov/Konkurs">GitHub</a></li>
    <br>
    <li><li><a href="lisamine.php">Kasutaja leht</a></li></li>
</ul>

<h1>FotoKonkurssi  halduse leht "Simple animal"</h1>
<?php
// tabeli konkurss sinu näitamine
$kask = $yhendus -> prepare("select id, nimi, pilt, lisamisaeg, kommentaar, punktid, avalik from konkurss");

$kask -> bind_result($id, $nimi, $pilt, $aeg, $kommentaar, $punktid, $avalik);
$kask->execute();
echo "<table>";
echo "<tr>
<th></th>
<th></th>
<th></th>
<th>Nimi</th>
<th>Pilt</th>
<th>Lisamisaeg</th>
<th>Punktid</th>
<th>Kommentaarid</th>
</tr>";

global $kommentaar;
//fetch() - извлечение данных из набора данных
while ($kask->fetch()) {
    echo "<tr>";

    //Peida - näita
    $avatekst = "Ava";
    $param = "avamine";
    $seisund = "Peidetud";
    if($avalik == 1){
        $avatekst = "Peida";
        $param = "peitmine";
        $seisund = "Avatud";
    }
    $ask = '"Continue?"';

    echo "<td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='?kustuta=$id' onclick='return confirm($ask);'>DELETE</a></td>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>$aeg</td>";
    echo "<td>$punktid</td>";
    echo "<td>$kommentaar</td>";
    echo "<td><a href='?kommentaar=$id'>Kommentaar nulliks</td>";
    echo "<td><a href='?punkt=$id'>Punktid nulliks</td>";

    echo "</tr>";
}
echo "</table>";
echo "<br>";

?>

</body>
</html>
