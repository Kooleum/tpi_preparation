<?php

$validate = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);

$gender = trim($gender);
$name = trim($name);

$error = "";

if ($validate == "Ajouter") {
    if (!empty($gender) && !empty($name)) {
        if ($error == "") {
            $res = addPerson($name, $gender);
            echo $res;
            if ($res) {
                $error = "<div class='alert alert-success'>Enregistrement ajouté avec succès</div>";
            } else {
                $error = "<div class='alert alert-danger'>Une erreur est survenue</div>";
            }
        }
    } else {
        $error = "<div class='alert alert-danger'>Tout les champs sont obligatoire</div>";
    }
}



function getSelectGenders()
{
    $gender = getAllGenders();

    $options = "";

    foreach ($gender as $gender) {
        $id = $gender['idGender'];
        $value = $gender['description'];
        $options .= "<option value='$id'>$value</option>";
    }
    return $options;
}
