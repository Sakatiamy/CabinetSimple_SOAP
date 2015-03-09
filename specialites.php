<h1>Specialites</h1>
<?php
require("./header.php");
?>
<h3>Gestion des specialites</h3>

<table border="1">
    <thead>
        <tr>
            <th>ID </th>
            <th>Nom </th>
            <th></th>
        </tr>
        <?php
        $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
        $result = $client->getSpecialites();
        $specialites = $result->return;
        if (isset($specialites)) {
            if (sizeof($specialites) == 1) {
                echo "<tr>"
                . "<td> " . $specialites->id . " </td>"
                . "<td> " . $specialites->nom . " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"specialites.php?id=" . $specialites->id . "\">"
                . "<input type=\"submit\" name=\"delete_specialite\" value=\"Delete Specialite\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($specialites as $specialite) {
                    echo "<tr>"
                    . "<td> " . $specialite->id . " </td>"
                    . "<td> " . $specialite->nom . " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"specialites.php?id=" . $specialite->id . "\">"
                    . "<input type=\"submit\" name=\"delete_specialite\" value=\"Delete Specialite\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune specialite</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_specialite'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deleteSpecialite(array(
                'id' => $_GET['id']
            ));
            echo 'La specialite a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une specialite</h3>
<form action="specialites.php" method="POST">
    Nom Specialite : <input type="texte" name="nom"/>
    <input type="submit" name="create_specialite" value="Creer Specialite"/>
</form>

<?php
if (isset($_POST['create_specialite'])) {
    $result = $client->createSpecialite(array(
        'nom' => $_POST['nom']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La specialite a ete creee';
}
?>


<h3>Modifier une specialite</h3>
<form action="specialites.php" method="POST">
    ID Specialite : <input type="number" name="id"/>
    Nom Specialite : <input type="texte" name="nom"/>
    <input type="submit" name="update_specialite" value="Modifier Specialite"/>
</form>

<?php
if (isset($_POST['update_specialite'])) {
    $result = $client->updateSpecialite(array(
        'id' => $_POST['id'],
        'nom' => $_POST['nom']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La specialite a ete modifiee';
}
?>

<?php
require("./footer.php");
