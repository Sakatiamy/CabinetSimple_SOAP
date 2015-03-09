<h1>Consultations</h1>
<?php
require("./header.php");
?>
<h3>Gestion des consultations</h3>

<table border="1">
    <thead>
        <tr>
            <th>ID </th>
            <th>Id_Medecin</th>
            <th>Nom_Medecin </th>
            <th>Id_Patient </th>
            <th>Nom_Patient </th>
            <th>Id_Salle </th>
            <th>Nom_Salle </th>
            <th>Id_Secretaire </th>
            <th>Nom_Secretaire </th>
            <th>Date </th>
            <th></th>
        </tr>
        <?php
        $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
        $result = $client->getConsultations();
        $consultations = $result->return;
        if (isset($consultations)) {
            if (sizeof($consultations) == 1) {
                $spe = $client->getSpecialites($consultations->id);
                $spec = $spe->return;
                echo "<tr>"
                . "<td> " . $consultations->id . " </td>"
                . "<td> " . $consultations->idMedecin->id . " </td>"
                . "<td> " . $consultations->idMedecin->nom . " </td>"
                . "<td> " . $consultations->idPatient->id . " </td>"
                . "<td> " . $consultations->idPatient->nom . " </td>"
                . "<td> " . $consultations->idSalle->id . " </td>"
                . "<td> " . $consultations->idSalle->nom . " </td>"
                . "<td> " . $consultations->idSecretaire->id . " </td>"
                . "<td> " . $consultations->idSecretaire->nom . " </td>"
                . "<td> " . $consultations->date. " </td>"
                . "<td>"
                . "<form method=\"POST\" action=\"consultations.php?id=" . $consultations->id . "\">"
                . "<input type=\"submit\" name=\"delete_consultation\" value=\"Delete Consultation\"/>"
                . "</form>"
                . "</td>"
                . "</tr>";
            } else {
                foreach ($consultations as $consultation) {
//                    $spe = $client->getSpecialiteConsultation($consultation->id);
//                    $spec = $spe->return;
//                    echo $spec->nom;
                    echo "<tr>"
                    . "<td> " . $consultation->id . " </td>"
                    . "<td> " . $consultation->idMedecin->id . " </td>"
                    . "<td> " . $consultation->idMedecin->nom . " </td>"
                    . "<td> " . $consultation->idPatient->id . " </td>"
                    . "<td> " . $consultation->idPatient->nom . " </td>"
                    . "<td> " . $consultation->idSalle->id . " </td>"
                    . "<td> " . $consultation->idSalle->nom . " </td>"
                    . "<td> " . $consultation->idSecretaire->id . " </td>"
                    . "<td> " . $consultation->idSecretaire->nom . " </td>"
                    . "<td> " . $consultation->date. " </td>"
                    . "<td>"
                    . "<form method=\"POST\" action=\"consultations.php?id=" . $consultation->id . "\">"
                    . "<input type=\"submit\" name=\"delete_consultation\" value=\"Delete Consultation\"/>"
                    . "</form>"
                    . "</td>"
                    . "</tr>";
                }
            }
        } else {
            echo "<tr>"
            . "<td> 0 </td>"
            . "<td> Aucune consultation</td>"
            . "</tr>";
        }
        if (isset($_POST['delete_consultation'])) {
            echo("Valeur ID = " . " " . $_GET['id']) . "<br/>";
            $result = $client->deleteConsultation(array(
                'id' => $_GET['id']
            ));
            echo 'La consultation a ete supprimee';
        }
        ?>
    </thead>
</table>

<h3>Ajouter une consultation</h3>
<form action="consultations.php" method="POST">
    ID Medecin : <input type="number" name="idMedecin"/>
    ID Patient : <input type="number" name="idPatient"/>
    ID Salle : <input type="number" name="idSalle"/>
    ID Secretaire : <input type="number" name="idSecretaire"/>
    Date Consultation : <input type="date" name="date"/>
    <input type="submit" name="create_consultation" value="Creer Consultation"/>
</form>

<?php
if (isset($_POST['create_consultation'])) {
    $client = new SoapClient('http://sakatiamy-voyager:8080/CabinetSOAP/CabinetSOAP?wsdl');
    $result = $client->createConsultation(array(
        'idMedecin' => $_POST['idMedecin'],
        'idPatient' => $_POST['idPatient'],
        'idSalle' => $_POST['idSalle'],
        'idSecretaire' => $_POST['idSecretaire'],
        'date' => $_POST['date']
    ));
    echo 'Le consultation a ete creee';
}
?>

<!--<h3>Modifier une consultation</h3>
<form action="consultations.php" method="POST">
    ID Consultation : <input type="number" name="id"/>
    ID Medecin : <input type="number" name="idMedecin"/>
    ID Patient : <input type="number" name="idPatient"/>
    ID Salle : <input type="number" name="idSalle"/>
    ID Secretaire : <input type="number" name="idSecretaire"/>
    Date Consultation : <input type="date" name="date"/>
    <input type="submit" name="update_consultation" value="Modifier Consultation"/>
</form>

<?php
//if (isset($_POST['update_consultation'])) {
//    $result = $client->updateConsultation(array(
//        'id' => $_POST['id'],
//        'idMedecin' => $_POST['idMedecin'],
//        'idPatient' => $_POST['idPatient'],
//        'idSalle' => $_POST['idSalle'],
//        'idSecretaire' => $_POST['idSecretaire'],
//        'date' => $_POST['date']
//    ));
//    echo 'La consultation a ete modifiee';
//}
?>

<?php
require("./footer.php");
