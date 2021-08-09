<?php 

require_once '../vendor/autoload.php';

use Azhar\Elms\Common\Database;
use Azhar\Elms\Updating\SetPassword;

session_start();

if(isset($_SESSION["loggedin"])  && ($_SESSION["status"] == "1")){

    if($_SESSION["user"] == "0"){

        header('location:twigWelcome.php');

      } elseif ($_SESSION["user"] == "1") { 
        
        header('location:twigAdmin.php');

      }
} 

if(isset($_GET['empid'])) {

    $id = base64_decode($_GET['empid']);

    $database = new Database();
    $db = $database->getConnection();

    $passCreate = new SetPassword($db, $id);

    $authorized = $passCreate->verified();
    
    if ($authorized){
       
        $_SESSION["flash"] = "You Are not Authorized";
       
        header("location: ../index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        
        if ($pass === $pass1) {
            
            $passCreate->updatePass($pass);

            $_SESSION["flash"] = "Password is Set You May Logged In";
    
            header("location: ../index.php");
        } 
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
