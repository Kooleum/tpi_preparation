<?php

function getSelectHobbies()
{
    $hobbies = getAllHobbies();

    $options = ";";

    foreach ($hobbies as $hobby) {
        $id = $hobby['idHobby'];
        $value = $hobby['comment'];
        $options.="<option value='$id'>$value</option>";
    }
    return $options;
}

function getSelectPersons()
{
    $persons = getAllPersons();

    $options = ";";

    foreach ($persons as $person) {
        $id = $person['idPerson'];
        $value = $person['name'];
        $options.="<option value='$id'>$value</option>";
    }
    return $options;
}
