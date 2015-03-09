<h1>Secretaires</h1>
<?php
require("./header.php");
?>
<h3>Gestion des secretaires</h3>

<table border="1">
    <thead>
        <tr>
            <th>ID </th>
            <th>Nom </th>
            <th>Prenom </th>
            <th>Adresse </th>
            <th>CP </th>
            <th>Ville </th>
            <th>Tel </th>
            <th></th>
        </tr>
        <?php
        $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
        $result = $client->getSecretaires();
        $secretaires = $result->return;
        if (isset($secretaires)) {
            if (sizeof($secretaires) == 1) {
                $spe = $client->getSpecialites($secretaires->id);
                $spec = $spe->return;
                echo "<tr>"
                . "<td> " . $secretaires->id . " </td>"
                . "<td> " . $secretaires->nom . " </td>"
                . "<td> " . $secretaires->prenom . " </td>"
                . "<td> " . $secretaires->adresse . " </td>"
                . "<td> " . $secretaires->cp . " </td>"
                . "<td> " . $secretaires->ville . " </td>"
                . "<td> " . $secretaires->tel . " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"secretaires.php?id=" . $secretaires->id . "\">"
                . "<input type=\"submit\" name=\"delete_secretaire\" value=\"Delete Secretaire\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($secretaires as $secretaire) {
//                    $spe = $client->getSpecialiteSecretaire($secretaire->id);
//                    $spec = $spe->return;
//                    echo $spec->nom;
                    echo "<tr>"
                    . "<td> " . $secretaire->id . " </td>"
                    . "<td> " . $secretaire->nom . " </td>"
                    . "<td> " . $secretaire->prenom . " </td>"
                    . "<td> " . $secretaire->adresse . " </td>"
                    . "<td> " . $secretaire->cp . " </td>"
                    . "<td> " . $secretaire->ville . " </td>"
                    . "<td> " . $secretaire->tel . " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"secretaires.php?id=" . $secretaire->id . "\">"
                    . "<input type=\"submit\" name=\"delete_secretaire\" value=\"Delete Secretaire\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune secretaire</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_secretaire'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deleteSecretaire(array(
                'id' => $_GET['id']
            ));
            echo 'La secretaire a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une secretaire</h3>
<form action="secretaires.php" method="POST">
    Nom Secretaire : <input type="texte" name="nom"/>
    Prenom Secretaire : <input type="texte" name="prenom"/>
    Date_Naissance Secretaire : <input type="date" name="dateNaissance"/>
    Adresse Secretaire : <input type="texte" name="adresse"/>
    CP Secretaire : <input type="texte" name="cp"/>
    Ville Secretaire : <input type="texte" name="ville"/>
    Tel Secretaire : <input type="texte" name="tel"/>
    <input type="submit" name="create_secretaire" value="Creer Secretaire"/>
</form>

<?php
if (isset($_POST['create_secretaire'])) {
    $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
    $result = $client->createSecretaire(array(
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'adresse' => $_POST['adresse'],
        'cp' => $_POST['cp'],
        'ville' => $_POST['ville'],
        'tel' => $_POST['tel']
    ));
    echo 'Le secretaire a ete creee';
}
?>

<h3>Modifier une secretaire</h3>
<form action="secretaires.php" method="POST">
    ID Secretaire : <input type="number" name="id"/>
    Nom Secretaire : <input type="texte" name="nom"/>
    Prenom Secretaire : <input type="texte" name="prenom"/>
    Date_Naissance Secretaire : <input type="date" name="dateNaissance"/>
    Adresse Secretaire : <input type="texte" name="adresse"/>
    CP Secretaire : <input type="texte" name="cp"/>
    Ville Secretaire : <input type="texte" name="ville"/>
    Tel Secretaire : <input type="texte" name="tel"/>
    <input type="submit" name="update_secretaire" value="Modifier Secretaire"/>
</form>

<?php
if (isset($_POST['update_secretaire'])) {
    $result = $client->updateSecretaire(array(
        'id' => $_POST['id'],
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'adresse' => $_POST['adresse'],
        'cp' => $_POST['cp'],
        'ville' => $_POST['ville'],
        'tel' => $_POST['tel']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La secretaire a ete modifiee';
}
?>

<?php
require("./footer.php");
