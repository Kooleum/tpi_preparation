<?php
DEFINE('DB_HOST', '127.0.0.1');
DEFINE('DB_NAME', 'prepara_tpi');
DEFINE('DB_USER', 'prepaAdmin');
DEFINE('DB_PASS', 'Super*2020');

/**
* Do the connection to the database
* @return PDO connection of the database
*/
function getConnexion()
{
     static $db = null;

     if ($db === null) {
          try {
               $connexionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '';
               $db = new PDO($connexionString, DB_USER, DB_PASS);
               $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (PDOException $e) {
               die('Erreur : ' . $e->getMessage());
          }
     }
     return $db;
}

//Transaction functions
function startTransaction()
{
     getConnexion()->begin_transaction();
}

function rollBackTransaction()
{
     getConnexion()->rollback();
}

function commitTransaction()
{
     getConnexion()->commit();
}

//Persons
/**
* Add a person into the persons table
* @param string personne name
* @param int person gender id
* @return bool state of the query
*/
function addPerson($name, $idGender){
    $connexion = getConnexion();
    $req = $connexion->prepare("INSERT INTO persons ('name', 'idGender) VALUES (:pName, :genderId)");
    $req->bindParam(":pName", $name, PDO::PARAM_STR);
    $req->bindParam(":genderId", $idGender, PDO::PARAM_INT);
    return $req->execute();
}

/**
 * Remove a given person from persons table
 * @param int person id you want to remove
 * @return bool state of the query
 */
function removePerson($idPerson){
    $connexion = getConnexion();
    $req = $connexion->prepare("DELETE FROM persons WHERE idPerson = :idP");
    $req->bindParam(":idP", $idPerson, PDO::PARAM_INT);
    return $req->execute();
}

//Hobbies
/**
* Add a hobby into the hobbies table
* @param string hobby name
* @return bool state of the query
*/
function addHobby($name){
    $connexion = getConnexion();
    $req = $connexion->prepare("INSERT INTO hobbies ('description') VALUES (:hName)");
    $req->bindParam(":hName", $name, PDO::PARAM_STR);
    return $req->execute();
}

/**
 * Remove a given hobby from hobbies table
 * @param int hobby id you want to remove
 * @return bool state of the query
 */
function removeHobby($idHobby){
    $connexion = getConnexion();
    $req = $connexion->prepare("DELETE FROM hobbies WHERE idHobby = :idh");
    $req->bindParam(":idh", $idHobby, PDO::PARAM_INT);
    return $req->execute();
}

//Genders
/**
* Add a gender into the genders table
* @param string hobby name
* @return bool state of the query
*/
function addGender($gender){
    $connexion = getConnexion();
    $req = $connexion->prepare("INSERT INTO genderes ('description') VALUES (:gender)");
    $req->bindParam(":gender", $gender, PDO::PARAM_STR);
    return $req->execute();
}

/**
 * Remove a given gender from genders table
 * @param int gender id you want to remove
 * @return bool state of the query
 */
function removeGender($idGender){
    $connexion = getConnexion();
    $req = $connexion->prepare("DELETE FROM genders WHERE idGender = :idGender");
    $req->bindParam(":idGender", $idGender, PDO::PARAM_INT);
    return $req->execute();
}

//Persons Hobbies

//Genders
/**
* Add a person hobby into the persons_has_hobbies table
* @param int person you want to add hobby
* @param int hobby you want to add person
* @return bool state of the query
*/
function addPersonHobby($idPerson, $idHobby){
    $connexion = getConnexion();
    $req = $connexion->prepare("INSERT INTO persons_has_hobbies ('idPerson', 'idHobby') VALUES (:idPerson, :idHobby)");
    $req->bindParam(":idPerson", $idPerson, PDO::PARAM_INT);
    $req->bindParam(":idHobby", $idHobby, PDO::PARAM_INT);
    return $req->execute();
}

/**
 * Remove a given person hobby from persons_has_hobbies table
 * @param int person id you want to remove hobby
 * @param int hobby id you want to remove from person
 * @return bool state of the query
 */
function removePersonHobby($idPerson, $idHobby){
    $connexion = getConnexion();
    $req = $connexion->prepare("DELETE FROM persons_has_hobbies WHERE idPerson = :idPerson AND idHobby = :idHobby");
    $req->bindParam(":idPerson", $idPerson, PDO::PARAM_INT);
    $req->bindParam(":idHobby", $idHobby, PDO::PARAM_INT);
    return $req->execute();
}