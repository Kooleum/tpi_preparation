<?php

$validate = filter_input(INPUT_POST, "submit", FILTER_SANITIZE_STRING);
$hobby = filter_input(INPUT_POST, "hobby", FILTER_SANITIZE_NUMBER_INT);
$person = filter_input(INPUT_POST, "person", FILTER_SANITIZE_NUMBER_INT);

$error = "";
echo 1;
if ($validate == "Ajouter") {
    if (!empty($hobby)) {
        echo 2;
        $personHobby = getAllHobbiesByPerson($person);
        if (!empty($personHobby)) {
            foreach ($personHobby as $ph) {
                if (strtolower($ph['idHobby']) == $hobby) {
                    $error = "<div class='alert alert-danger'>Cet enregistrement existe déjà</div>";
                }
            }
        }
        if ($error == "") {
            $res = addPersonHobby($person, $hobby);
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


function getSelectHobbies()
{
    $hobbies = getAllHobbies();

    $options = "";

    foreach ($hobbies as $hobby) {
        $id = $hobby['idHobby'];
        $value = $hobby['description'];
        $options.="<option value='$id'>$value</option>";
    }
    return $options;
}

function getSelectPersons()
{
    $persons = getAllPersons();

    $options = "";

    foreach ($persons as $person) {
        $id = $person['idPerson'];
        $value = $person['name'];
        $options.="<option value='$id'>$value</option>";
    }
    return $options;
}
