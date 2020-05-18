<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une personne</title>
</head> 
<body class="bg-dark text-white">
    <?php require_once 'nav.php'; ?>
    <div class="container mt-2">
    <h2>Ajouter une personne</h2>
    <form action="#" method="post">
        <div class="form-group"> 
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" required/>
        </div>
        <div class="form-group">
            <label for="gender">Genre</label>
            <select id="gender" class="form-control" name="gender" required>
                <option></option>
                <?= getSelectGenders() ?>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Ajouter" name="submit" />
    </form>
    </div>
    <?php require_once 'footer.html';?>
</body>
</html>