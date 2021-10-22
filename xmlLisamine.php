<?php
$xml=simplexml_load_file("Elisaveta2.xml");


if(isset($_POST['nimi'])){
    //vormi tekstkastist saadud nimi
    $nimi=$_POST['nimi'];
    $lnimi=$_POST['lnimi'];

    $xml_sugupuu=$xml->addChild('inimene');
    $xml_sugupuu->addChild('nimi', $nimi);
    $xml_l=$xml_sugupuu->addChild('lapsed')->addChild('inimene');
    $xml_l->addChild('nimi', $lnimi);



    $xmlDoc=new DOMDocument("1.0", "UTF-8");
    $xmlDoc->loadXML($xml->asXML(), LIBXML_NOBLANKS);
    $xmlDoc->formatOutput=true;
    if (isset($_POST['old'])) {
        $xmlDoc->save('Elisaveta2.xml');
    }
    elseif (isset($_POST['uue'])) {
        $xmlDoc->save('test1.xml');
    }
    elseif (isset($_POST['uue'])) {
        $xmlDoc->save('test1.xml');
    }
    header("refresh:0;");

}

?>
<!DOCTYPE html>
<html lang ="et">
<head>
    <title>Sugupuu andmete lisamine </title>
</head>
<body>
<h1>Sugupuu andmete lisamine XML olemasoleva faili</h1>
<form method="post" action="">
    <label for="nimi">Vanema nimi</label>
    <input type="text" name="nimi" id="nimi" placeholder="Kirjuta vanema nimi">
    <br>
    <label for="lnimi">Lapse nimi</label>
    <input type="text" name="lnimi" id="lnimi" placeholder="Kirjuta lapse nimi">
    <input type="submit" value="Sisesta sugupuu.xml faili" name="old" id="old">
    <input type="submit" value="Sisesta uue xml faili" name="uue" id="uue">
</form>

<br>

</table>
</body>
</html>

    <table border="1">
        <tr>
            <th>Vanavanem</th>
            <th>Lapsevanem</th>
        </tr>
<?php
//on olemas
foreach($xml -> xpath('//inimene') as $inimene) {
    echo "<tr>";
    echo "<td>" . $inimene->nimi . "</td>";
    if ($inimene -> lapsed){
        $resultat= "";
        foreach ($inimene -> lapsed -> inimene as $laps){
            $resultat = $resultat.$laps -> nimi. ", ";
        }
        $resultat = substr($resultat, 0, -2);
        echo "<td>".$resultat."</td>";
    }
    else{
        echo "<td>None</td>";
    }
    echo "</tr>";
}

?>