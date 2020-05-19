<?php

if (count(explode('=', $_SERVER['REQUEST_URI'])) >= 2)
    $actual = explode('=', $_SERVER['REQUEST_URI'])[1];
else
    $actual = "index"

?>

<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <a class="navbar-brand" href="?action=index">Preparation TPI</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?= $actual == 'index' ? 'active' : '' ?>" href="?action=index">Home</a>
            </li>
            <?php
            echo '<li class="nav-item ' . ($actual == 'addPerson' ? 'active' : '') . '"><a class="nav-link" href="?action=addPerson">Ajouter une personne</a></li>';
            echo '<li class="nav-item ' . ($actual == 'addHobby' ? 'active' : '') . '"><a class="nav-link" href="?action=addHobby">Ajouter un hobby</a></li>';
            echo '<li class="nav-item ' . ($actual == 'addPersonHobby' ? 'active' : '') . '"><a class="nav-link" href="?action=addPersonHobby">Aujouter un hobby à une personne</a></li>';
            echo '<li class="nav-item ' . ($actual == 'addGender' ? 'active' : '') . '"><a class="nav-link" href="?action=addGender">Aujouter un genre</a></li>';

            ?>
        </ul>
    </div>
</nav>