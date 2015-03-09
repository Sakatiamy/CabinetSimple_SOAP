<h1>Salles</h1>
<?php
require("./header.php");
?>
<h3>Gestion des salles</h3>

<table border="1">
    <thead>
        <tr>
            <th>ID </th>
            <th>Nom </th>
            <th></th>
        </tr>
        <?php
        $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
        $result = $client->getSalles();
        $salles = $result->return;
        if (isset($salles)) {
            if (sizeof($salles) == 1) {
                echo "<tr>"
                . "<td> " . $salles->id . " </td>"
                . "<td> " . $salles->nom . " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"salles.php?id=" . $salles->id . "\">"
                . "<input type=\"submit\" name=\"delete_salle\" value=\"Delete Salle\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($salles as $salle) {
                    echo "<tr>"
                    . "<td> " . $salle->id . " </td>"
                    . "<td> " . $salle->nom . " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"salles.php?id=" . $salle->id . "\">"
                    . "<input type=\"submit\" name=\"delete_salle\" value=\"Delete Salle\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune salle</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_salle'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deleteSalle(array(
                'id' => $_GET['id']
            ));
            echo 'La salle a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une salle</h3>
<form action="salles.php" method="POST">
    Nom Salle : <input type="texte" name="nom"/>
    <input type="submit" name="create_salle" value="Creer Salle"/>
</form>

<?php
if (isset($_POST['create_salle'])) {
    $result = $client->createSalle(array(
        'nom' => $_POST['nom']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La salle a ete creee';
}
?>


<h3>Modifier une salle</h3>
<form action="salles.php" method="POST">
    ID Salle : <input type="number" name="id"/>
    Nom Salle : <input type="texte" name="nom"/>
    <input type="submit" name="update_salle" value="Modifier Salle"/>
</form>

<?php
if (isset($_POST['update_salle'])) {
    $result = $client->updateSalle(array(
        'id' => $_POST['id'],
        'nom' => $_POST['nom']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La salle a ete modifiee';
}
?>

<?php
require("./footer.php");
