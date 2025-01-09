<?php 

$page = isset($_GET['page']) ? $_GET['page'] : 'acceuil'; 

switch ($page) {
    case 'accueil':
        include_once 'view/accueil.php';
        break;
    case "guestbook":
        if (file_exists('view/contact.php')) {
            include 'view/livre_d_or.php';
        } else {
            echo "Page indisponible.";
        }
        break;
    case 'contact':
        if (file_exists('view/contact.php')) {
            include 'view/contact.php';
        } else {
            echo "Page de contact indisponible.";
        }
        break;

    case 'connexion':
        if (file_exists('view/login_register.php')) {
            $action = isset($_GET['action']) ? $_GET['action'] : 'login';
            include 'view/login_register.php';
        } else {
            echo "Page indisponible.";
        }
        break;
        

    default:
        include 'view/404.php';
}
