<?php
$xml=simplexml_load_file("Elisaveta2.xml");

// väljastab inimeste laste andmed
function getChildrens($people){
    $result= array($people);
    $childs=$people->lapsed->inimened;

    if(empty($childs))
        return $result;

    foreach ($childs as $child){
        $array=getChildrens($child);
        $result=array_merge($result, $array);
    }
    return $result;
}
//lisab massiivi getChildrens funktsiooni
function getPeoples($xml){
    $array =getChildrens($xml);
    return $array;
}
$peoples=getPeoples($xml);

function getparent($peoples, $people){
    if($people == null) return null;

    foreach($peoples as $parent){
        if(!hasChilds($parent)) continue;

        foreach ($parent->lapsed->inimene as $child){
            if($child->nimi ==$people->nimi)
                return $parent;
        }
    }
    return null;
}

function hasChilds($people){
    return !empty($people->lapsed->inimene);
}


// otsing vanema nimi järgi
function searchByParentName($query){
    global $peoples;
    $result=array();
    foreach ($peoples as $people){
        $parent=getParent($peoples, $people);
        if (empty($parent)) continue;
        if(substr(strtolower($parent->nimi), 0,
                strlen($query))==strtolower($query)){
            array_push($result, $people);
        }
    }
    return $result;
}


// otsing lapsi nimi järgi
function searchByChildName($query){
    global $peoples;
    $result=array();
    foreach ($peoples as $people){

        if(substr(strtolower($people->nimi), 0,
                strlen($query))==strtolower($query)){
            array_push($result, $people);
        }
    }
    return $result;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sugupuu funktsioonidega</title>
</head>
<body>
<h1>Sugupuu tabelina</h1>
<form action="?" method="post">
    <fieldset name="otsing">Otsing
        <br>
        <input type="radio" name="searchBy" value="nameParent">Vanema nimi
        <br>
        <input type="radio" name="searchBy" value="nameChild" checked> Lapse nimi
        <br>
        <input type="text" name="search" placeholder="Sisesta nimi">
        <input type="submit" value="Ok">
    </fieldset>
</form>

<table border="1">
    <tr>
        <th>Vanavanem</th>
        <th>Lapsevanem</th>
        <th>Laps</th>
        <th>Sünniaasta</th>
        <th>Vanus</th>
    </tr>
    <?php
    if(!empty($_POST["search"])){
        $radioButton=$_POST["searchBy"];
        if($radioButton == "nameParent"){
            $result=searchByParentName($_POST["search"]);
        }
        else if ($radioButton == "nameChild"){
            $result=searchByChildName($_POST["search"]);
        }
        //on olemas
        foreach($result as $people){

            $parent=getParent($peoples, $people);
            if(empty($parent)) continue;

            $parentOfParent=getParent($peoples, $parent);

            echo "<tr>";
            if(empty($parentOfParent)){
                echo "<td bgcolor='#ff4500'>vanem puudub</td>";
            }
            else echo "<td>".$parentOfParent ->nimi."</td>";
            echo "<td>".$parent ->nimi."</td>";
            echo "<td>".$people ->nimi."</td>";
            echo "<td>".$people->attributes()->synnaaasta."</td>";
            // tänane aasta
            $yearNow=(int)date("Y");
            $synniaasta=(int)$people->attributes()->synnaaasta;

            echo "<td>". (int)($yearNow-$synniaasta)."</td>";


            echo "</tr>";
        }
    }

    else {
        // inimesed mis on olemas
        foreach($peoples as $people){

            $parent=getParent($peoples, $people);
            if(empty($parent)) continue;

            $parentOfParent=getParent($peoples, $parent);

            echo "<tr>";
            if(empty($parentOfParent)){
                echo "<td bgcolor='#ff4500'>vanem puudub</td>";
            }
            else echo "<td>".$parentOfParent ->nimi."</td>";
            echo "<td>".$parent ->nimi."</td>";
            echo "<td>".$people ->nimi."</td>";
            echo "<td>".$people->attributes()->synnaaasta."</td>";
            // tänane aasta
            $yearNow=(int)date("Y");
            $synniaasta=(int)$people->attributes()->synnaaasta;

            echo "<td>". (int)($yearNow-$synniaasta)."</td>";


            echo "</tr>";
        }
    }
    ?>


</table>
<h2> Kõik nimed, kellel on min 2 last</h2>
<?php
echo "<ul>";
foreach ($peoples as $people){
    $lapsed= $people->lapsed->inimene;
    if(empty($lapsed)) continue;
    if(count($lapsed) >=2){
        echo "<li>";
        echo $people->nimi." - ".count($lapsed). " last";
    }
}
echo "</ul>";
?>

</body>
</html>
