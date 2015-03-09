<h1>Patients</h1>
<?php
require("./header.php");
?>
<h3>Gestion des patients</h3>

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
        $result = $client->getPatients();
        $patients = $result->return;
        if (isset($patients)) {
            if (sizeof($patients) == 1) {
                $spe = $client->getSpecialites($patients->id);
                $spec = $spe->return;
                echo "<tr>"
                . "<td> " . $patients->id . " </td>"
                . "<td> " . $patients->nom . " </td>"
                . "<td> " . $patients->prenom . " </td>"
                . "<td> " . $patients->adresse . " </td>"
                . "<td> " . $patients->cp . " </td>"
                . "<td> " . $patients->ville . " </td>"
                . "<td> " . $patients->tel . " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"patients.php?id=" . $patients->id . "\">"
                . "<input type=\"submit\" name=\"delete_patient\" value=\"Delete Patient\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($patients as $patient) {
//                    $spe = $client->getSpecialitePatient($patient->id);
//                    $spec = $spe->return;
//                    echo $spec->nom;
                    echo "<tr>"
                    . "<td> " . $patient->id . " </td>"
                    . "<td> " . $patient->nom . " </td>"
                    . "<td> " . $patient->prenom . " </td>"
                    . "<td> " . $patient->adresse . " </td>"
                    . "<td> " . $patient->cp . " </td>"
                    . "<td> " . $patient->ville . " </td>"
                    . "<td> " . $patient->tel . " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"patients.php?id=" . $patient->id . "\">"
                    . "<input type=\"submit\" name=\"delete_patient\" value=\"Delete Patient\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune patient</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_patient'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deletePatient(array(
                'id' => $_GET['id']
            ));
            echo 'La patient a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une patient</h3>
<form action="patients.php" method="POST">
    Nom Patient : <input type="texte" name="nom"/>
    Prenom Patient : <input type="texte" name="prenom"/>
    Date_Naissance Patient : <input type="date" name="dateNaissance"/>
    Adresse Patient : <input type="texte" name="adresse"/>
    CP Patient : <input type="texte" name="cp"/>
    Ville Patient : <input type="texte" name="ville"/>
    Tel Patient : <input type="texte" name="tel"/>
    <input type="submit" name="create_patient" value="Creer Patient"/>
</form>

<?php
if (isset($_POST['create_patient'])) {
    $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
    $result = $client->createPatient(array(
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaissance' => $_POST['dateNaissance'],
        'adresse' => $_POST['adresse'],
        'cp' => $_POST['cp'],
        'ville' => $_POST['ville'],
        'tel' => $_POST['tel']
    ));
    echo 'Le patient a ete creee';
}
?>

<h3>Modifier une patient</h3>
<form action="patients.php" method="POST">
    ID Patient : <input type="number" name="id"/>
    Nom Patient : <input type="texte" name="nom"/>
    Prenom Patient : <input type="texte" name="prenom"/>
    Date_Naissance Patient : <input type="date" name="dateNaissance"/>
    Adresse Patient : <input type="texte" name="adresse"/>
    CP Patient : <input type="texte" name="cp"/>
    Ville Patient : <input type="texte" name="ville"/>
    Tel Patient : <input type="texte" name="tel"/>
    <input type="submit" name="update_patient" value="Modifier Patient"/>
</form>

<?php
if (isset($_POST['update_patient'])) {
    $result = $client->updatePatient(array(
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
    echo 'La patient a ete modifiee';
}
?>

<?php
require("./footer.php");
