<?php
/* Eksempel 1 */

if (isset($_POST["fornavn"], $_POST["etternavn"])) {
    $fornavn = $_POST["fornavn"];
    $etternavn = $_POST["etternavn"];

    print("God dag $fornavn $etternavn <br />");
}
?>
