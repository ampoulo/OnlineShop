<?php

set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("view/View.php");


class Router {
    //stockage de données
    private $storage="";

    //constructeur
    function __construct(){
        //$this->store = $pdo;
    }
    //la fonction main
    function main(){
        session_start(); 
        
        
        $feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
		$_SESSION['feedback'] = '';

        $view = new View($this,$feedback);                
        $ctrl = new Controller($view);
    //    if(!key_exists("action",$_GET) && !key_exists("id",$_GET)  && !key_exists("ajout",$_GET)){            
    //         $ctrl->showArticleList();
    //     }
    //     else if(key_exists("id",$_GET)){  
    //         //$_SESSION['pagefrom'] = $_GET['id'];                   
    //         $ctrl->showArticleDetail($_GET['id']);
    //     }
    //     //ajouter au panier l'element $_GET['ajout']
    //     else if(key_exists('ajout',$_GET)){   
    //         (key_exists('account',$_SESSION))?$ctrl->AjouterAuPanier($_GET['ajout']):$view->makeLoginFormPage();
    //     }

        /* Analyse de l'URL */
		$articleId = key_exists('article', $_GET) ? $_GET['article'] : null;
        $action = key_exists('action', $_GET) ? $_GET['action'] : null;  
        $account=key_exists('account',$_SESSION)?$_SESSION['account']:null;      
        
		if ($action === null) {
			/* Pas d'action demandée : par défaut on affiche
	 	 	 * la page d'accueil, sauf si une couleur est demandée,
	 	 	 * auquel cas on affiche sa page. */
			$action = ($articleId === null) ? "accueil" : "voir";
        }
        try{
            switch ($action) {
                    case 'voir':
                        if($action===null)
                            $view->makeUnknownActionPage();                            
                        else{
                            $ctrl->showArticleInformation($articleId);
                        }break;
                    case 'detailArticle': 
                        $ctrl->detailArticle($articleId);
                    case "inscription"://la page d'inscription
                        $ctrl->nouveauCompte();    
                        break;  
                    case "sauverNouveauCompte":
                        $ctrl->sauverNouveauCompte($_POST);                                                
                        break;   
                    case "connexion"://se connecter                        
                        $ctrl->connexionPage();
                        break;
                    case 'privateAccount':
                        $ctrl->privateAccount($_POST);break;
                    case 'deconnexion':
                        $ctrl->deconnexion();
                        break;
                    case 'supprimerArticle':
                        $ctrl->supprimerArticle($articleId);
                        break;
                    case 'perso':
                        $view->makeAccountPage($account);break;
                    case 'ajouterAuPanier':
                        $ctrl->ajouterAuPanier($account,$articleId);
                        break;
                    case 'listerPanier':
                        $ctrl->showPanierPage($account);
                        break;
                    case 'apropos':
                        $view->apropos();break;
                    case 'livraison':
                        $ctrl->livraison($article);break;
                    case 'accueil':
                        $ctrl->showArticleList();
                            break;                    
                    default:
                        $content = "unknown entity";
                }
            }
            catch(Exception $e){
                //page demandée non prévue
                $view->makeUnexpectedErrorPage($e);
            }
        $view->render();                               
    }   
      
    //enregistrer un nouveau compte
    public function saveCreatedAccount(){
        return ".?action=sauverNouveauCompte";        
    }
    //lien dinscription
     public function getInscriptionURL(){
        return ".?action=inscription";        
    }
    //se connecter
    public function getConnexionURL(){
        return ".?action=connexion";        
    }
    //connexion reussie
    public function getSessionUrl(){
        return ".?action=privateAccount";        
    }
    //liste des Articles
    public function getListeActicles(){
        return ".";
    }
    public function AjouterAuPanier($id){
        return ".?article=$id&amp;action=ajouterAuPanier";
    }
    //se deconnecter
    public function deconnexion(){
        return '.?action=deconnexion';
    }
    //lister les articles dans le panier
    public function panierPage($idAccount){
        return ".?account=$idAccount&amp;action=listerPanier";
    }
    //suppresson d'un compte
    public function supprimerCompte($id){
        return ".?account=$id&amp;action=supprimerCompte";
    }
    //suppression d'un article
    public function supprimerArticle($id){
        return".?article=$id&amp;action=supprimerArticle";
    }
    //modifier un compte
    public function modifierCompte($id){
        return ".?account=$id&amp;action=modifierCompte";
    }
    //enregistrer les données modifiées du compte
    public function updateModifiedAccount($id){
        return ".?id=$id&amp;action=update";
    }
    //acceder au detail d'un article
    public function detailArticle($id){
        return ".?article=$id";
    }
    //url vers la recherche
    public function recherche(){
        return ".?action=recherche";
    }
    //parametre compte
    public function accountPage(){
        return ".?action=perso";
    }

    public function livraison($id){
        return ".?article=$id&amp;action=livraison";
    }
    public function apropos(){
        return ".?action=apropos";
    }


   /* Fonction pour le POST-redirect-GET,
 	 * destinée à prendre des URL du routeur
 	 * (dont il faut décoder les entités HTML) */
	public function POSTredirect($url, $feedback) {
		$_SESSION['feedback'] = $feedback;
		header("Location: ".htmlspecialchars_decode($url), true, 303);
        die;
    }
}

?>