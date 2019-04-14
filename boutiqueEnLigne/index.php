<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src/");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");
require_once("src/control/Controller.php");
require_once("src/lib/SqlTool.php");
//require_once 'src/model/Storage.php';
require_once ("src/model/account/AccountStorage.php");
require_once ("src/model/article/ArticleStorage.php");
require_once ("src/model/account/Account.php");
require_once ("src/model/article/Article.php");
require_once ("src/model/panier/PanierStorage.php");
require_once ("src/model/panier/Panier.php");
/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
//$store = new ObjectFileDB($_SERVER['TMPDIR'].'/TOTO.txt');
//$store = SqlTool::getInstance();
//$animalStorage = new AnimalStorageFile($store);
//$animalStorage->reinit();
$router = new Router();
$router->main();



?>
