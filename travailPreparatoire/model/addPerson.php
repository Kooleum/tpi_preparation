<?php

function getSelectGenders()
{
    $gender = getAllGenders();

    $options = ";";

    foreach ($gender as $gender) {
        $id = $gender['idGender'];
        $value = $gender['comment'];
        $options.="<option value='$id'>$value</option>";
    }
    return $options;
}
