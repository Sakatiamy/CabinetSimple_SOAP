<h1>Medecins</h1>
<?php
require("./header.php");
?>
<h3>Gestion des medecins</h3>

<table border="1">
    <thead>
        <tr>
            <th>ID </th>
            <th>Nom </th>
            <th>Prenom </th>
            <th>Id_Specialite </th>
            <th>Nom_Specialite </th>
            <th>Adresse </th>
            <th>CP </th>
            <th>Ville </th>
            <th>Tel </th>
            <th></th>
        </tr>
        <?php
        $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
        $result = $client->getMedecins();
        $medecins = $result->return;
        if (isset($medecins)) {
            if (sizeof($medecins) == 1) {
                $spe = $client->getSpecialites($medecins->id);
                $spec = $spe->return;
                echo "<tr>"
                . "<td> " . $medecins->id . " </td>"
                . "<td> " . $medecins->nom . " </td>"
                . "<td> " . $medecins->prenom . " </td>"
                . "<td> " . $medecins->idSpecialite->id . " </td>"
                . "<td> " . $medecins->idSpecialite->nom . " </td>"
                . "<td> " . $medecins->adresse . " </td>"
                . "<td> " . $medecins->cp . " </td>"
                . "<td> " . $medecins->ville . " </td>"
                . "<td> " . $medecins->tel . " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"medecins.php?id=" . $medecins->id . "\">"
                . "<input type=\"submit\" name=\"delete_medecin\" value=\"Delete Medecin\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($medecins as $medecin) {
//                    $spe = $client->getSpecialiteMedecin($medecin->id);
//                    $spec = $spe->return;
//                    echo $spec->nom;
                    echo "<tr>"
                    . "<td> " . $medecin->id . " </td>"
                    . "<td> " . $medecin->nom . " </td>"
                    . "<td> " . $medecin->prenom . " </td>"
                    . "<td> " . $medecin->idSpecialite->id . " </td>"
                    . "<td> " . $medecin->idSpecialite->nom . " </td>"
                    . "<td> " . $medecin->adresse . " </td>"
                    . "<td> " . $medecin->cp . " </td>"
                    . "<td> " . $medecin->ville . " </td>"
                    . "<td> " . $medecin->tel . " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"medecins.php?id=" . $medecin->id . "\">"
                    . "<input type=\"submit\" name=\"delete_medecin\" value=\"Delete Medecin\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune medecin</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_medecin'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deleteMedecin(array(
                'id' => $_GET['id']
            ));
            echo 'La medecin a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une medecin</h3>
<form action="medecins.php" method="POST">
    Nom Medecin : <input type="texte" name="nom"/>
    Prenom Medecin : <input type="texte" name="prenom"/>
    Date_Naissance Medecin : <input type="date" name="dateNaissance"/>
    ID Specialite : <input type="number" name="idSpecialite"/>
    Adresse Medecin : <input type="texte" name="adresse"/>
    CP Medecin : <input type="texte" name="cp"/>
    Ville Medecin : <input type="texte" name="ville"/>
    Tel Medecin : <input type="texte" name="tel"/>
    <input type="submit" name="create_medecin" value="Creer Medecin"/>
</form>

<?php
if (isset($_POST['create_medecin'])) {
    $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
    $result = $client->createMedecin(array(
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'idSpecialite' => $_POST['idSpecialite'],
        'adresse' => $_POST['adresse'],
        'cp' => $_POST['cp'],
        'ville' => $_POST['ville'],
        'tel' => $_POST['tel']
    ));
    echo 'Le medecin a ete creee';
}
?>

<h3>Modifier une medecin</h3>
<form action="medecins.php" method="POST">
    ID Medecin : <input type="number" name="id"/>
    Nom Medecin : <input type="texte" name="nom"/>
    Prenom Medecin : <input type="texte" name="prenom"/>
    Date_Naissance Medecin : <input type="date" name="dateNaissance"/>
    ID Specialite : <input type="number" name="idSpecialite"/>
    Adresse Medecin : <input type="texte" name="adresse"/>
    CP Medecin : <input type="texte" name="cp"/>
    Ville Medecin : <input type="texte" name="ville"/>
    Tel Medecin : <input type="texte" name="tel"/>
    <input type="submit" name="update_medecin" value="Modifier Medecin"/>
</form>

<?php
if (isset($_POST['update_medecin'])) {
    $result = $client->updateMedecin(array(
        'id' => $_POST['id'],
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'idSpecialite' => $_POST['idSpecialite'],
        'adresse' => $_POST['adresse'],
        'cp' => $_POST['cp'],
        'ville' => $_POST['ville'],
        'tel' => $_POST['tel']
    ));
    echo("Nom = " . " " . $_POST['nom']) . "<br/>";
    echo 'La medecin a ete modifiee';
}
?>

<?php
require("./footer.php");
