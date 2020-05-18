<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connection</title>
</head>

<body class="text-white text-center bdbg">
    <?php
    require_once 'nav.php';
    ?>
    <div class="container d-flex w-100 p-3 mx-auto flex-column  align-content-center">
        <div class="">
        </div>
        <div class="col-lg-6 mx-auto mt-5">
            <?php foreach ($error as $key => $value) {
                echo "<p class='erreur'>$value</p>";
            } ?>
            <?= <<<FORMLESSON
                <form id="formulaireStudent" class="" action="" method="POST">
                    <div id="exStudentSelect">
                    $exStudentSelec
                    </div>
                    <div id="formStuden">
                        $idLessonSlect
                        $formUser
                    </div> 
                    </form>
                    <button class="btn btn-outline-success" onclick="addStudentSelector()">+</button>
                    <input class="btn btn-success" name="submitSt" type="submit" onclick="validatedStudentForm()">
                    <p>$validation</p>
                
                FORMLESSON;
            ?>
        </div>
        <div class="col-lg-6 mx-auto mt-5">
            <?php foreach ($error as $key => $value) {
                echo "<p class='erreur'>$value</p>";
            } ?>
            <?= <<<FORMLESSON
                <form id="formulaireClass" class="" action="" method="POST">
                    <div id="exClassSelect">
                        $exClassSelec
                    </div>
                    <div id="formClass">
                        $idLessonSlect
                        $formClass
                    </div>
                </form>
                <button  class="btn btn-outline-success" onclick="addClassSelector()">+</button>
                <input class="btn btn-success" name="submitCl" type="submit" onclick="validatedClassForm()">
                <p>$validation</p>
                FORMLESSON;

            echo "<a target='_blank' href='?action=downloadGraph&file=" . explode('/', $path)[1] . "&fileType=img&fileName=" . $startDate . "_" . $endDate . "' class='ml-3 mr-2 mt-1'><button class='btn btn-success'>Télécharger</button></a>";

            ?>
        </div>
        <?php require_once "footer.html" ?>
    </div>
    <script src="js/addUserToLesson.js"></script>
</body>

</html>