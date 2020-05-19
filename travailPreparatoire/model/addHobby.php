<?php

$validate = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$hobby = filter_input(INPUT_POST, "hobby", FILTER_SANITIZE_STRING);

$hobby = trim($hobby);

$error = "";

if ($validate == "Ajouter") {
    if (!empty($hobby)) {
        $hobbies = getAllHobbies();
        if (!empty($hobbies)) {
            foreach ($hobbies as $h) {
                if (strtolower($h['description']) == strtolower($hobbies)) {
                    $error = "<div class='alert alert-danger'>Cet enregistrement existe déjà</div>";
                }
            }
        }
        if ($error == "") {
            $res = addHobby($hobby);
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
