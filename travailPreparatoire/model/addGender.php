<?php

$validate = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);

$gender = trim($gender);

$error = "";

if ($validate == "Ajouter") {
    if (!empty($gender)) {
        $genders = getAllGenders();
        if (!empty($genders)) {
            foreach ($genders as $g) {
                if (strtolower($g['description']) == strtolower($gender)) {
                    $error = "<div class='alert alert-danger'>Cet enregistrement existe déjà</div>";
                }
            }
        }
        if ($error == "") {
            $res = addGender($gender);
            if ($res) {
                $error = "<div class='alert alert-success'>Enregistrement ajouté avec succès</div>";
            } else {
                $error = "<div class='alert alert-danger'>Une erreur est survenue</div>";
            }
        }
    } else {
        $error = "<div class='alert alert-danger'>Le champs genre est obligatoire</div>";
    }
}
