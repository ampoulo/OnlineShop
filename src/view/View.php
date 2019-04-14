<?php

set_include_path("./");

//require_once("../model/Animal.php");
require_once("src/model/account/AccountCreation.php");

class View{

    private $router;
    private $title;
    private $content;
    private $style;
    private $account;

    function __construct(Router $router, $feedback){
        $this->feedback = $feedback;
        $this->router=$router;
        $this->title=null;
        $this->content=null;
    }

    function render(){
        include "squelette.php";
    }
    //page de connexion
    public function makeLoginFormPage(AccountCreation $builder){
        $auth ="<div class='connexionPage'>";
        $auth .="    <div class='imgLogin'></div>";
        $auth.="    <form action='".$this->router->getSessionUrl()."' method='post' class='formulaire1'>  ";
        $auth.="        <fieldSet class='formulaire'>";
        $auth.="        <div class='logotitCnx'><div class='logoForm'></div><h1 class='titCnx'>Connexion</h1></div>";
                            if($builder->getError('loginOuPasswdIncorrect')!==null){
                                $auth.="<span class='rouge'> ".$builder->getError('loginOuPasswdIncorrect')."</span>";
                            }
                            $builder->addError('loginOuPasswdIncorrect',null);


        $auth.="        <label class='login'> email : <input type='text' name='mail' placeholder='ex : mami' value='".self::htmlesc($builder->getData(AccountCreation::MAIL))."' required></label>";
                        if($builder->getError(AccountCreation::MAIL))
                            $auth.="<span class='rouge'> ".$builder->getError(AccountCreation::MAIL)."</span>";
        $auth.="        <label class='psswd'> mot de passe : <input type='password' name='password' required> </label>";
                            if($builder->getError(AccountCreation::PASSWD))
                                $auth.="<span class='rouge'> ".$builder->getError(AccountCreation::PASSWD)."</span>";
        $auth.="        <button type='submit' name='submitAuth'>submit</button>
                        <p class='pinscrir'>Pas de compte ?
                        <a class='lieninsc' href='".$this->router->getInscriptionURL()."'> Inscrivez-vous</a></p>";
        $auth.="    </fieldSet>";
        $auth.=" </form>";
        $auth.="</div>";
        $this->title = "page d'authentification ";
        $this->content.=$auth;
    }
    /*la page d'un compte*/
    public function makeAccountPage(Account $account){
        $body="<section class='accountPage'>";
        $body .= "<h1> Parametre du compte </h1>";
        $body .= "<ul acountInfos>";
        $body .= "<li >nom : ".$account->getNom()."</li>";
        $body .= "<li >mail : ".$account->getMail()."</li>";
        $body .= "<li >mot de passe : ********** </li>";
        $body .="<form action='".$this->router->getListeActicles()."' method='POST' class='modifBoutton'><button>modifier</button></form>";
        $body .=" </section>";
        $this->title = "compte ".$account->getNom();
        $this->content=$body;
    }

    /*modification d'un compte*/
    public function makeModifyAccountPage($id, AccountCreation $builder){
            $this->title = "Modifier le compte";
            $content ="<h1>Modifier vos données<h1> ";
            $content .="<section class='modificationCompte'>";
            $content .= '<form action="'.$this->router->updateModifiedAccount($id).'" method="POST">'."\n";            
            $content .=      self::accountForm($builder);                
            $content.="      <button type='submit' name='valider'>valider</button>";
            $content.="  </form>";
            $content.="</section>";
            $this->content .= self::makeInscriptionPage($builder);
            $this->content .= '<button>Modifier</button>'."\n";
            $this->content .= '</form>'."\n";
    }
    
  
    /*afficher un formulaire de création d'un compte*/
    public function makeAccountCreationPage($builder){
        $this->title = "inscription"; 
        $formulaire ="<section class='connexionPage'>";        
        $formulaire .=" <form action='".$this->router->saveCreatedAccount()."' method='post'>";
        
        $formulaire .="<fieldSet class='formulaire'>";
        $formulaire.="<div class='logotitCnx'><div class='logoForm'></div><h1 class='titCnx'>Inscription</h1></div>";
        if(key_exists('loginExistence',$builder->getErrtable()) && $builder->getError('loginExistence')!==null){
                        $formulaire.="<span class='rouge'> <p>".$builder->getError('loginExistence')."</p></span>";
                    }
        $formulaire .=      self::accountForm($builder);                
        $formulaire.="      <button type='submit' name='valider'>valider</button>";
        $formulaire.=" </fieldset>";
        $formulaire.="  </form>";
        $formulaire.="</section>";
        $this->content .= $formulaire;
   }

   /*afficher la liste des articles sur la page d'accueil*/
    public function makeListPage($liste){

        $main="<ul class='listeArticle'>";
        foreach($liste as $list){
            $main.="<li class='article'>
                        <a href='".$this->router->detailArticle($list->getId())."'>
                                <figure><img  class='imageProduit' src='src/view/images/".$list->getImage()."' alt='".$list->getImage()."' /></figure>
                                <ul class='infoProduit'>
                                    <li class='infoProduitL titreProduit'>".$list->getTitre()."</li>
                                    <li class='infoProduitLi prix'>Prix :".$list->getPrix()."</li>
                                    <li class='infoProduitLi'>Couleur :".$list->getCouleur()."</li>
                                </ul>
                        </a>
                </li>";
        }
        $main.="</ul>";
        //var_dump($main);
        $this->content.=$main;
        $title = "liste d'articles";

        $this->title = $title;
    }

     /*page affichant les détails d'un article*/
     public function makeDetailPage(Article $article){
        //$ajouter = (key_exists('account',$_Session)?""
        $main="<section class='detailArticle'>";
        $main.="<figure><img class='imgInfoproduit' src='src/view/images/".$article->getImage()."' alt='".$article->getImage()."'></figure>";
        $main.="<div class='infoProduitDetail'>
                    <ul >
                        <li><h2>".$article->getTitre()."</h2></li>
                        <li class='LiProduit' id='enstock'>En Stock!</li>
                        <li class='LiProduit'><strong>Prix :</strong>".$article->getPrix()."</li>
                        <li class='LiProduit'><strong>Taille :</strong>".$article->getTaille()."</li>
                        <li class='LiProduit'><strong>Couleur :</strong>".$article->getCouleur()."</li>
                        <li class='LiProduit'><strong>Description :</strong>".$article->getDescription()."</li>
                    </ul>";
                
        $main.="<a  href='".$this->router->ajouterAuPanier($article->getId())."' class='ajoutPanier' ><div class='ajouterPanier'>Ajouter au panier</div></a>";
        $main.="  ";
        $main.="<div class='livraison'>
                <div class='livraisonStan'><div class='ImnglivraisonStan'></div><p>
                        <strong>Livraison Standard</strong> gratuite
                        </p></div>
                <div class='livraisonExp'>
                <div class='ImnglivraisonExp'></div>
               <p> <strong>Livraison Express</strong> 9,95 €<br>
                    1-2 jours ouvrables en commandant avant 15h</p></div></div>
                    </div>";
        $main.="</section>";
        //var_dump($main);
        $this->content.=$main;
        $this->title =$article->getTitre();
        }
/*article inexistant dans la bdd*/
        public function makeUnexpectedArticle(){
            $this->title="erreur";
            $this->content="<h1>Erreur</h1>";
            $this->content.="l'article demandé n'existe pas"; 

        }
/*lister les produits dans le panier*/
public function makePanierPage($liste){
    $this->title='votre panier';
     $panier="<ul class='listProduitPanier'>";
     foreach($liste as $list){
        $panier.="<li class='infoProduitPanier'>
                    <a href='".$this->router->detailArticle($list->getId())."'>
                        <figure><img  class='imageProduitPanier' src='src/view/images/".$list->getImage()."'></figure></a>
                        <ul class='infoProduitLi'>
                            <li class='titreProduit'>".$list->getTitre()."</li>
                            <li id='prixProduit'>Prix :".$list->getPrix()."</li>
                            <li id='couleurProduit'>Couleur :".$list->getCouleur()."</li>
                        </ul>
                    
                        <div class='SupAchPanierBtn'>";
                            if(!key_exists('account',$_SESSION)){
                                $panier.='<form action="'.$this->router->getConnexionURL($list->getId()).'" method="POST">'."\n";
                                    $panier .= "<button>Acheter</button>\n</form>\n";
                            }
                            else{
                                $panier.='<form action="'.$this->router->livraison($_SESSION['account']->getId()).'" method="$_POST"><button>Acheter </button></form>';
                                
                            }
                            $panier.='<form action="'.$this->router->supprimerArticle($list->getId()).'" method="POST">'."\n";
                            $panier .= "<button>Supprimer</button>\n</form>\n";
                            $panier ." </div>                                       
                </li>";
    }
    $panier.="</ul>";
    
    $this->content.=$panier;
}
/*action inconnue*/
public function makeUnknownActionPage(){
    $this->title="page inconnue";
    $this->content.=" <h1> Page inconnue </h1>";
    $this->content.="  retourner à l'<a href='".$this->router->getListeActicles()."'>accueil </a>";
}
/*compte inexistant*/
public function makeUnknownAccountPage(){
    $this->title="Erreur";
    $this->content.=" <h1> Ce compte n'existe pas </h1>";
    $this->content.="  retourner à l'<form action='".$this->router->getListeActicles()."' method='POST'>accueil </a>";
}

/*feedback ajout dans le panier reussi*/
public function ajoutDansPanierReussi($id){
    $this->router->POSTredirect($this->router->getListeActicles(),"$id a été ajouté à votre panier !");
}
/*feedback confirmer suppression */
public function confirmerSuppressionArticle($id){
    $this->router->POSTredirect($this->router->panierPage(''),"$id est supprimé de votre panier !");
}
/*feedback confirmer suppression et panier vide*/
public function confirmerSuppressionEtViderPanier($id){
    $this->router->POSTredirect($this->router->getListeActicles(''),"$id votre Panier est maintenant vide !");
}
/* confirmation creation page*/
public function confirmationCreationCompte($accountId){
    $this->router->POSTredirect($this->router->getListeActicles(''),"création de compte réussie");
}
/*********************************************************************************/
/*                     méthodes utilitaires                                      */
/*********************************************************************************/

//formulaire du compte pour modifier ou s'inscrire
public function accountForm($builder){
    $formulaire ="<label class='label'> nom : <input type='text'  placeholder='sara' name='nom' value='".self::htmlesc($builder->getData(AccountCreation::NAME))."'>";
                if($builder->getError(AccountCreation::NAME)!==null)
                    $formulaire.="<span class='rouge'> ".self::htmlesc($builder->getError(AccountCreation::NAME))."</span>";
    $formulaire.="</label>";
    $formulaire.="  <label  class='label'> mail : <input type='text' name='mail' value='".self::htmlesc($builder->getData(AccountCreation::MAIL))."' placeholder='xyz@mail.com'>";
                if($builder->getError(AccountCreation::MAIL)!==null)
                    $formulaire.= "<span class='rouge'>".$builder->getError(AccountCreation::MAIL)."</span>";
    $formulaire.=" </label>";
    $formulaire.="  <label  class='label'> mot de passe : <input type='password' name='password' value='".self::htmlesc($builder->getData(AccountCreation::PASSWD))."' >";
                if($builder->getError(AccountCreation::PASSWD)!==null)
                    $formulaire.= "<span class='rouge'>".$builder->getError(AccountCreation::PASSWD)."</span>";
    $formulaire .="</label>";

    return $formulaire;
}



/* la barre de navigation */
public function navig(){//la barre de navigation: bien organiser la navigation
    $nav="<header class='entete'>";
    //le logo de fashionEtu
    $nav .="<a href='".$this->router->getListeActicles()."'><div class='logo'></div></a>";
    //barre de recherche
    $nav .="<form action='".$this->router->recherche()."' class='search-container'>
                <input type='text' id='search-bar' placeholder='suits, double brested, smoking...'>
                <button type='submit' class='recherche'></button>
            </form>";
    $nav.="<nav class='menuNav'>
            <ul class='navig'>";
    //vérifie si l'utilisateur est connecté
    if(!key_exists('account',$_SESSION)){ //pas de connexion           
        $nav.=  "<li class='deconnecte connexionli'>
                    <a href='".$this->router->getConnexionURL()."' class='lienConnexionLi'><div class='connexion' ></div><span>connexion</span></a>
                            <ul class='deroule'>                                   
                                <li><a href='".$this->router->getConnexionURL()."'>se connecter</a></li>
                                <li><a href='".$this->router->getInscriptionURL()."'>s'inscrire</a></li>
                            </ul>
                </li>";
                if(key_exists('count',$_SESSION) && $_SESSION['count']!==0){                                        
                        $nav.=  "<li class='panierli'>
                                    <a href='".$this->router->panierPage('')."'>
                                        <div class='panier'></div>
                                        <span class='rouge'>".$_SESSION['count']." voir mon panier</span>
                                    </a>
                                </li>";
                }else{
                    $nav.=  "<li class='paniervide'><div class='panier'></div><span>panier vide</span></li>";
                }
    }else{ //utilisateur connectée
        $account = $_SESSION['account'];
        $nav.=  "<li class='connecte connexionli'> 
                    <a href='".$this->router->getListeActicles()."' class='lienConnexionLi'><div class='connexion' ></div><span>".$account->getNom()."</span></a>
                            <ul class='deroule'>                                   
                                <li><a href='".$this->router->accountPage()."'>parametre compte</a></li>
                                <li><a href='".$this->router->deconnexion()."'>déconnexion</a></li>
                            </ul>                                   
                </li>";
                $count=(key_exists('count',$_SESSION))?$_SESSION['count']:"";
                if($count!==0 && $count!=="")
                    $nav.=  "<li class='panierli'>
                                <a href='".$this->router->panierPage($account->getId())."' class='lienConnexionLi'>
                                    <div class='panier'> </div>
                                    <span class='rouge'>".$count ." voir mon panier</span>
                                </a>
                            </li>";
                else 
                    $nav.=  "<li class='paniervide'><div class='panier'> </div> <span>panier vide</span></li>";
    }
    $nav.="</ul> </nav>";
    $nav.="</header>";
    return $nav;
}
    /*le pied de page qui apparaît dans toutes les pages*/
    public function footer(){
        $footer="<footer class='footer'>
                    <ul class='paiements'>
                        <li> Paiments </li>
                        <li class='visa'>visa<li>
                        <li class='mastercard'>mastercard<li>
                        <li class='paypal'>paypal<li>
                    </ul>
                    <ul class='disponibleSur'>
                    <li> Disponible </li>
                        <li class='android'>android<li>
                        <li class='apple'>apple<li>
                        <li class='windows'>windows<li>
                    </ul>
                    <ul class='contact'>
                    <li> Contact </li>
                        <li class='facebook'>facebook<li>
                        <li class='instagram'>instagram<li>
                        <li class='twitter'>twitter<li>
                    </ul>
                    <ul><li>                        <p>&copy; EtuMsuits</p>
                    </li><li>                        <p><a href='".$this->router->apropos()."'> A propos </a></p>
                    </li></ul>                      
                </footer>";
                return $footer;
    }
    /*page d'erreur imprévue*/
    public function makeUnexpectedErrorPage(){
        $this->title="page d'erreur";

        $this->content = "page d'erreur ";
    }
    public function apropos(){
        $this->title='à propos ';
        $content = "
        etudiants: 21612706 et 21813986
            <h1> A propos du site</h1>
            <p>Il s'agit d'un site de e-commerce. Des vestes classes y sont vendus.</p>     
            

A fin de pratiquer les notions vue en cours et remplir les consignes demandées en dm nous avons choisi d’implémenter un mini-site de e-commerce.

Notre site comporte 3 objets importants:
Account
Article
Panier
<ul>
<li>1-la classe account : concerne l’utilisateur de site a fin qu’il puisse s’authentifier et faire ses achats.</li>
<li>2-la classe article : la description d’un article posé sur le site.</li>
<li>3-la classe panier : correspond a l’ensemble des articles choisi par un utilisateur.</li>
</ul>
 A savoir sur notre site :
<p>
 -Un utilisateur peut s'inscrire en fournissant certaines informations personnelles
-Un utilisateur connecté et non connecté peut ajouter des articles à son panier 
-Un utilisateur connecté et non connecté peux supprimer des articles de son panier
- Un utilisateur connecté peux modifier ajouter et supprimer de son panier enregistré
- Un simple utilisateur peux consulter les articles voir le detail de ces derniers il peut les ajouter au panier mais il faut s'inscrir pour passer acheter.
</p>

les contraintes techniques :
<p>
-Utilisation de l’architecture MVCR vue en cours
-Utilisation de MYSQL
-Valisation du html5
-surtout l'implémentation du panier</p>


        ";
        $this->content=$content;
    }
    
	/* Une fonction pour échapper les caractères spéciaux de HTML,
	* car celle de PHP nécessite trop d'options. */
	public static function htmlesc($str) {
		return htmlspecialchars($str,
			/* on échappe guillemets _et_ apostrophes : */
			ENT_QUOTES
			/* les séquences UTF-8 invalides sont
			* remplacées par le caractère �
			* au lieu de renvoyer la chaîne vide…) */
			| ENT_SUBSTITUTE
			/* on utilise les entités HTML5 (en particulier &apos;) */
			| ENT_HTML5,
			'UTF-8');
	}
    //facilite le debug en affichant le contenu d'une variable
    public function makeDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.var_export($variable, true).'</pre>';
    }
}


    
  // //page d'inscription
    // public function makeInscriptionPage(AccountCreation $builder){
    //     $this->content = $this->navig();
    //     $auth ="<div class='InscriptionPage'>";
    //     $auth.="    <form action='".$this->router->saveCreatedAccount()."' method='post'>";
    //     $auth.="        <fieldSet class='formulaire'>";
    //     $auth.="            <div class='logotitCnx'>
    //                             <div class='logoForm'></div>
    //                             <h1 class='titCnx'>Inscription</h1>
    //                         </div>";
    //     $auth.="            <label for='name' class='nom'> Nom : <input type='text' name='nom' placeholder='ex : mami' value=".$builder->getData(AccountCreation::NAME)." required>";
    //                         // if($builder->getError(AccountCreation::NAME)!==null){
    //                         //     $auth.="<span class='error'> ".$builder->getError(AccountCreation::NAME_REF)."</span>";
    //                         // }
    //     $auth.="            </label>";
    //     $auth.="            <label for='mail' class='mail'> mail : <input type='text' name='mail' placeholder='ex : amadou@mail.com' value=".$builder->getData(AccountCreation::MAIL)."required>";
    //                             // if($builder->getError(AccountCreation::MAIL)!==null){
    //                             //     $auth.="<span class='error'> ".$builder->getError(AccountCreation::MAIL)."</span>";
    //                             // }
    //     $auth.="            </label>";
    //     $auth.="            <label for='password' class='psswd'> mot de passe : <input type='password' name='password' required></label>";                               
    //     $auth.="            <button type='submit'>submit</button>";
    //     $auth.="        </fieldSet>";
    //     $auth.="    </form>";
    //     $auth.="</div>";
    //     $this->title = "page inscription";
    //     $this->content.=$auth;
    //     $this->content.=$this->footer();
    // }
   