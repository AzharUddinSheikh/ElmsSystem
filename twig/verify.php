<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Database;
use Azhar\Elms\Users;

session_start();

if(isset($_SESSION["loggedin"])  && ($_SESSION["status"] == "1")){

    if($_SESSION["user"] == "0"){

        header('location:welcome.php');

      } elseif ($_SESSION["user"] == "1") { 

        header('location:admin.php');
      }
} 

$database = new Database();
$db = $database->getConnection();

$users = new Users($db);

if(isset($_GET['empid'])) {

    $id = base64_decode($_GET['empid']);

    $authorized = $users->verified($id);

    if ($authorized){

        $_SESSION["flash"] = "You Are not Authorized";

        header("location: ../index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $password = $_POST['pass'];

        $users->setPassword($password, $id);

        $_SESSION["flash"] = "Password is Set You May Logged In";

        header("location: ../index.php");
    }

} else {

    header('location: ../index.php');
}

$filter  = new \Twig\TwigFilter('base64_encode', function($string) {
    return base64_encode($string);
});

$loader = new \Twig\Loader\FilesystemLoader('../view');

$twig = new \Twig\Environment($loader);

$twig->addFilter($filter);

$twig->addGlobal('session', $_SESSION);

$template = $twig->load('partials/verify.html.twig');

echo $template->render();
?>
