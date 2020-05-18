<?php

/**
 * @author Alexandre Benzonana
 * @version 1.2
 */

class Image 
{

    private const GREEN_MIN = 20;
    private const YELLOW_MAX = 20;
    private const ORANGW_MAX = 18;
    private const RED_MAX = 16;

    private const LEFT_MARGIN = 100;
    private const RIGHT_MARGIN = 50;
    private const TOP_MARGIN = 50; //Min 30
    private const BOTTOM_MARGIN = 70;

    private const TEMP_SPACE = 50;
    private const TIME_SPACE = 120;
    
    private const FONT_SIZE = 15;
    
    private $height;
    private $width;
    private $image;
    private $savePath;
    private $backColor;

    /** 
     * @param int with of the result image
     * @param int height of the result image
     */
    public function __construct(int $width, string $savePath)
    {
        $this->set_Width($width);
    }

    public function drawGraph(array $temperatures, $classInfo)
    {

        $image = imagecreate($this->width, $this->height);

        $color = $this->backColor;

        imagecolorallocate($image, $color[0], $color[1], $color[2]);

        $white = imagecolorallocate($image, 250, 250, 250);

        $white = imagecolorallocate($image, 250, 250, 250);
        $green = imagecolorallocate($image, 30, 100, 20);
        $yellow = imagecolorallocate($image, 198, 88, 0);
        $orange = imagecolorallocate($image, 255, 170, 0);
        $red = imagecolorallocate($image, 250, 50, 50);
        $lightRed = imagecolorallocate($image, 250, 10, 50);

        $graphHeight = $this->height - ($this::TOP_MARGIN + $this::BOTTOM_MARGIN);
        $graphWidth = $this->width - ($this::LEFT_MARGIN + $this::RIGHT_MARGIN);
        $graph00 = ['x' => $this::LEFT_MARGIN, 'y' => $this->height - $this::BOTTOM_MARGIN];

        $nbGraphTimeValues = round(($graphWidth) / $this::TIME_SPACE, 0);
        $nbTempValues = round(($graphHeight) / $this::TEMP_SPACE, 0);

        //comment
        $fontSize = $this::FONT_SIZE;

        $uniqueId = md5(rand(-99999, 999999) . json_encode($temperatures) . rand(-999999, 999999));

        $minDateValue = min($temperatures);
        $maxDateValue = max($temperatures);

        $maxTempValue = -50;

        foreach ($temperatures as $value) {
            if ($value['temperatureState'] > $maxTempValue)
                $maxTempValue = $value['temperatureState'];
        }

        $valueNumber = count($temperatures);
        $minTempValue=1;
        $tempGap = abs($maxTempValue - $minTempValue) / ($nbTempValues);

        $interval = date_diff(new DateTime($minDateValue['dateState']), new DateTime($maxDateValue['dateState']));

        $timeJump = $valueNumber / $nbGraphTimeValues;

        //Write graph time interval and class on the top left
        $font = "arial.otf";
        imagettftext($image, $fontSize, 0, $this::LEFT_MARGIN / 10, $this->height - $this::BOTTOM_MARGIN / 1.7, $white, $font, "°C/Time");

        //draw axis
        for ($i = 0; $i < 5; $i++) {
            imageline($image, $graph00['x'] - $i - 1, $graph00['y'] + 25, $graph00['x'] - $i - 1, $graph00['y'] - $graphHeight - 10, $white);
        }

        //Write Temperatures and Temp landmark
        $iteration = 0;
        $posY18 = $graph00['y'] - 30 - (18 - $minTempValue) * ($graphHeight - 30) / ($maxTempValue - $minTempValue);
        $posY0 = $graph00['y'] - 30 - (0 - $minTempValue) * ($graphHeight - 30) / ($maxTempValue - $minTempValue);

        for ($i = $minTempValue; (float) $i <= (float) $maxTempValue + 0.00001; $i += $tempGap) {

            $posY = $graph00['y'] - 30 - ($i - $minTempValue) * ($graphHeight - 30) / ($maxTempValue - $minTempValue);

            if (abs($posY - $posY18) > $this::TEMP_SPACE / 3 && abs($posY - $posY0) > $tempGap / 3) {


                for ($j = $graph00['x']; $j < $this::LEFT_MARGIN + $graphWidth + 10; $j += 20) {
                }
            }
            $iteration++;
        }

        //Write Date/Time and Time landmark
        $iteration = 0;
        for ($i = 0; $i < $valueNumber; $i += ceil($timeJump)) {

            $posX = $graph00['x'] + 60 + $iteration * $this::TIME_SPACE;

            for ($j = $graph00['y']; $j > $this::TOP_MARGIN - 10; $j -= 20) {
            }

            $dateTime = explode(" ", $temperatures[ceil($i)]['dateState']);
            $date = $dateTime[0];
            $time = explode(":", $dateTime[1])[0] . ":" . explode(":", $dateTime[1])[1];

            imagettftext($image, $fontSize, 0, $posX - $this::TIME_SPACE / ($this::TIME_SPACE / 25), $graph00['y'] + 30, $white, $font, $time);
            imagettftext($image, $fontSize, 0, $posX - $this::TIME_SPACE / ($this::TIME_SPACE / 50), $graph00['y'] + 50, $white, $font, $date);
            $iteration++;
        }

        //Draw warning landMark for 18°C and 16°C
        if ($minTempValue <= 18) {
            for ($i = $graph00['x'] / 2; $i < $graphWidth + $graph00['x']; $i += 30) {

                imageline($image, $i, $posY18, $i + 15, $posY18, $red);
            }
            imagettftext($image, 15, 0, $this::LEFT_MARGIN / 8, $posY18 + $fontSize / 2, $orange, $font, "18");

            if ($minTempValue <= 0) {
                $width = 1024;
                for ($i = 40; $i < 0.99 * $width; $i += 20) {
                    imageline($image, $i, $posY0, $i + 5, $posY0, $lightRed);
                }
                imagettftext($image, 15, 0, 10, $posY0 + $fontSize / 2, $red, $font, "0");
            }
        }

        $posX = $graph00['x'] + 60;
        for ($i = 0; $i < $valueNumber - 1; $i++) {

            $posY = $graph00['y'] - 30 - ($temperatures[$i]['temperatureState'] - $minTempValue) * ($graphHeight - 30) / ($maxTempValue - $minTempValue);
            $posY2 = $graph00['y'] - 30 - ($temperatures[$i + 1]['temperatureState'] - $minTempValue) * ($graphHeight - 30) / ($maxTempValue - $minTempValue);

            if ($temperatures[$i]['temperatureState'] < 16 || $temperatures[$i + 1]['temperatureState'] < 16) {
                $color = $red;
            } elseif ($temperatures[$i]['temperatureState'] < 18 || $temperatures[$i + 1]['temperatureState'] < 18) {
                $color = $yellow;
            } elseif ($temperatures[$i]['temperatureState'] < 20 || $temperatures[$i + 1]['temperatureState'] < 20) {
                $color = $orange;
            } else {
                $color = $green;
            }
            imageline($image, $posX, $posY - 1, $posX + ($graphWidth - 60) / $valueNumber, $posY2 - 1, $color);
            imageline($image, $posX, $posY, $posX + ($graphWidth - 60) / $valueNumber, $posY2, $color);
            imageline($image, $posX, $posY + 1, $posX + ($graphWidth - 60) / $valueNumber, $posY2 + 1, $color);
            $posX += ($graphWidth - 60) / $valueNumber;
        }

        //Store the final image
        if (imagepng($image, "graphs/" . $uniqueId . ".png")) {
            return "graphs/" . $uniqueId . ".png";
        }
        return false;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function get_Height()
    {
        return $this->height;
    }
    /**
     * @param int height min 400 
     */
    public function set_Height(int $height)
    {
        if ($height >= 400)
            $this->height = $height;
        else
            $this->height = 400;
    }

    public function get_Width()
    {
        return $this->width;
    }

    /**
     * @param int widht min 800 
     */
    public function set_Width(int $width)
    {
        if ($width >= 800)
            $this->width = $width;
        else
            $this->width = 800;
    }

    public function get_SavePath()
    {
        return $this->savePath;
    }

    /**
     * @param string path where the image have to be saved 
     */
    public function set_SavePath(string $savePath)
    {
        $this->savePath = $savePath;
    }

    public function get_BackColor()
    {
        return $this->backColor;
    }

    /**
     * @param string background color for the image, format "r, g, b" 
     */
    public function set_BackColor(string $color)
    {
        $color = explode(',', $color);

        if (count($color) != 3) {
            throw new Exception('Invalid color, expected format "r, g, b" ');
            return;
        } elseif ($color[0] < 0 || $color[0] > 255 || $color[1] < 0 || $color[1] > 255 || $color[2] < 0 || $color[2] > 255) {
            throw new Exception('Invalid color, value have to be between 0 and 255');
            return;
        }
        $color = array_map('trim', $color);
        $this->backColor = $color;
    }

    public function getCard()
    {
        $card = "<div class='card text-white bg-dark mt-2 mr-0 col-md-" . $this->cardSize . "'>";
        $card .= "<div class='card-header'>" . $this->buildingName . " Salle " . $this->classNumber . "</div>";
        $card .= "<div class='card-body'><h5 class='card-title'>" . $this->temperature;
        $card .= "</h5><p class='card-text'>" . $this->dateTime . "</p></div></div>";
        return $card;
    }
}

DEFINE('DB_HOST', '127.0.0.1');
// DEFINE('DB_HOST', '10.5.48.40');
// DEFINE('DB_HOST', 'hibou.lab.ecinf.ch:3307');
DEFINE('DB_NAME', 'arl');
DEFINE('DB_USER', 'arl');
DEFINE('DB_PASS', 'Super*2020');

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


function changeUserPassword($password, $idUser)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("UPDATE users SET `password`=:pass WHERE idUser = :idUser");
    $req->bindParam(":pass", $password, PDO::PARAM_STR);
    $req->bindParam(":idUser", $idUser, PDO::PARAM_STR);
    return $req->execute();
}

function removeUser($id)
{
    $connexion = getConnexion();
    $req = $connexion->prepare("DELETE FROM `userRole` WHERE idUser = :id");
    $req->bindParam(":id", $id, PDO::PARAM_INT);
    if ($req->execute()) {
        $req = $connexion->prepare("DELETE FROM `users` WHERE idUser = :id");
        $req->bindParam(":id", $id, PDO::PARAM_INT);
        $req->queryString;
        return $req->execute();
    }
    return false;
}

function getUserRole($id)
{
    $conn = getConnexion();
    $req = $conn->prepare("SELECT `idRole` FROM `userRole` WHERE idUser = :id");
    $req->bindParam(":id", $id, PDO::PARAM_INT);
    $req->execute();
    $res = $req->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

function addArrive($user)
{
    $connexion = getConnexion();
    $dateNow = date('Y-m-d H:i:s');
    $req = $connexion->prepare("INSERT INTO presences (timeArrive, idUser) VALUES (:arriveTime, :user)");
    $req->bindParam(":arriveTime", $dateNow, PDO::PARAM_STR);
    $req->bindParam(":user", $user, PDO::PARAM_INT);
    $req->execute();
}


$string = <<<STRING
some text
some text
STRING;


throw new Exception('Invalid cardSize, expected number between 1 and 12');


$idUser = FILTER_INPUT(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$idRole = FILTER_INPUT(INPUT_GET, 'role', FILTER_SANITIZE_STRING);

session_start();
$_SESSION['variable'];

require_once 'footer.html';
require 'footer.html';
include_once 'footer.html';
include 'footer.html';

if (isset($_SESSION['role']))
    $role = $_SESSION['role'];
else
    $role = "Anonymous";

$permission = [
    "Anonymous" => [
        "default" => "login",
        "login" => "login",
        "logout" => "logout",
    ],
];

if (!array_key_exists($action, $permission[$role])) {
    $action = "default";
}

try {
    require './controller/' . $permission[$role][$action] . '.php';
} catch (Exception $e) {
}

echo "some text";

header("Location: ?action=admin");
exit();


$morningDiffEnd = date_diff(new DateTime($presAll[0]['timeDepart']), $morningClassesPeriods[array_key_last($morningClassesPeriods)]['end']);

$timeOfTheDay = date('H:i');

