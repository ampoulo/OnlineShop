<?php

class Controller{
    private $view;    
    private $articleStore;
    private $accountStore; 
    private $panierStorage; 
    private $accountCreation;
    private $currentAccountBuilder;

    function __construct(View $view){
        $this->view=$view;
        $this->currentAccountBuilder=  key_exists('currentAccountBuilder', $_SESSION) ? $_SESSION['currentAccountBuilder'] : null;;
		$this->modifiedAccountBuilders = key_exists('modifiedAccountBuilders', $_SESSION) ? $_SESSION['modifiedAccountBuilders'] : array();
        $this->articleStore = new ArticleStorage();
        $this->accountStore = new AccountStorage();
        $this->panierStorage = new PanierStorage();

    }

    //afficher les informations
    public function showAccountInformation(Account $account){
        if(key_exists($account,$this->accountStore->readAll())){
            //$this->view->makeStartPage($this->store->read($id));
            $this->view->makeAccountPage($this->accountStore->read($account));
        }
        else{   
           $this->view->makeUnknownAnimalPage();
           var_dump("compte pas dispo ".$account);
        }

    }
    public function detailArticle($articleId){
        return $this->view->makeDetailPage($this->articleStore->read($articleId));
    }
    //ajouter au panier
    public function ajouterAuPanier($account, $idArticle){
        $article = $this->articleStore->read($idArticle);
        if($article===false){
            $this->view->makeUnexpectedArticle();
        }
        else{
            if($account===null){
                $_SESSION['article'][$idArticle]=$article;     
                $_SESSION['count']=count($_SESSION['article']);
                $articles = $_SESSION['article'][$idArticle];       
                $nbArticles = count($_SESSION['article']);         
                //$panier
            }
            else
            {
                $created = $this->panierStorage->create($account->getId(),$idArticle);                        
                $panier = $this->panierStorage->count($_SESSION['account']->getId()); 
                $_SESSION['count'] = intval($panier);
            }
            $this->view->ajoutDansPanierReussi($article->getTitre());
        }        
        
    }

    public function pagePerso($id){        
        if(key_exists('account',$_SESSION) && $this->accountStore->read($account->getId())!==null){            
            $this->view->makeAccountPage($_SESSION['account']);            
        }
        else
            $this->view->makeUnknownAccountPage();
    }
    public function showPanierPage($account){
        if($account===null){
            if(key_exists('article',$_SESSION)){
                $listPanierArticle= $_SESSION['article'];    
                $this->view->makePanierPage($listPanierArticle);            
            }
        }
        else{
            $accountId = $this->accountStore->read($account->getId());
            if($accountId===null) 
                $this->view->makeUnknownAccountPage();     
            else
                $listPanierArticle = $this->articleStore->readAll2($_SESSION['account']->getId());
                $this->view->makePanierPage($listPanierArticle);
        }    
        
    }

    public function supprimerArticle($idArticle){
        /*verifie l'article en bdd*/
        $article=$this->articleStore->read($idArticle);
        if($article===null){
            $this->view->makeUnknownAccountPage(); 
        }
        else{
            if(!key_exists('account',$_SESSION)){            
                $article = $_SESSION['article'][$idArticle];
                unset($_SESSION['article'][$idArticle]); 
                if($_SESSION['count']===1){
                    unset($_SESSION['count']);  
                    $this->view->confirmerSuppressionEtViderPanier($article->getTitre());
                }
                else
                    $_SESSION['count']=$_SESSION['count']-1;
            }
            /*verifie l'article en bdd*/
            else{    
                $articleId=intval($this->panierStorage->read2($idArticle));
                $this->panierStorage->delete($articleId);
                $_SESSION['count']=$_SESSION['count']-1;
                if($_SESSION['count']<=0){                    
                    unset($_SESSION['count']);
                    $this->view->confirmerSuppressionEtViderPanier($article->getTitre());
                }                                
            }
            $this->view->confirmerSuppressionArticle($article->getTitre());
        }                 

    }
    
    //afficher les informations
    public function showArticleInformation($id){
        if($this->articleStore->read($id)!==-1){         
            $this->view->makeDetailPage($this->articleStore->read($id));
        }
        else{
            $this->view->makeUnknownActionPage();
        }
    }
    public function nouveauCompte(){
        /* Affichage du formulaire de création de compte
        * avec les données par défaut. */
        if($this->currentAccountBuilder===null){
            $this->currentAccountBuilder=new AccountCreation();
        }
        $this->view->makeAccountCreationPage($this->currentAccountBuilder);

    }
    //enregistrer un nouveau compte
    public function sauverNouveauCompte($data){
        $this->currentAccountBuilder = new AccountCreation($data);               
        if ($this->currentAccountBuilder->isValid()){
  			/* On crée le nouveau compte */
            $account = $this->currentAccountBuilder->createAccount($this->accountStore);            
            if($account===false)
                $this->view->makeAccountCreationPage($this->currentAccountBuilder);                            
            else{/* On l'ajoute en BD */
                $this->accountStore->create($account);
                /* On détruit le builder courant */
                $this->currentAccountBuilder = null;
                /* On redirige vers la page parametre de l'utilisateur*/
                $this->view->confirmationCreationCompte($account->getId());
                
            }
        }else
            $this->view->makeAccountCreationPage($this->currentAccountBuilder);
    }
    //authentification
    public function privateAccount($authData){
        $this->currentAccountBuilder = new AccountCreation($authData);
        $isValid = $this->currentAccountBuilder->isValid();           

        if($isValid){

            $checkProfile = $this->accountStore->checkAuth($this->currentAccountBuilder->getData('mail'),$this->currentAccountBuilder->getData('password'));               
            if($checkProfile===false){                
                $this->currentAccountBuilder->addError('loginOuPasswdIncorrect', "<strong>email</strong> ou <strong>mot de passe</strong> incorrecte");
                $this->view->makeLoginFormPage($this->currentAccountBuilder);

            }
            else{
                $_SESSION['account']=$checkProfile;
                $_SESSION['count']=intval($this->panierStorage->count($checkProfile->getId()));
                $this->showArticleList();
            }                
        }else{            
            $this->view->makeLoginFormPage($this->currentAccountBuilder);
        }
    }
    public function connexionPage(){
        $this->view->makeLoginFormPage(new AccountCreation(array())); 
    }
    //afficher la liste  d'article
    public function showArticleList(){         
        $this->view->makeListPage($this->articleStore->readAll());
    }
    //se déconnecter
    public function deconnexion(){
        session_unset();
        $this->showArticleList();
    }

    //afficher la liste de compte par l'admin
    public function showAccountList(){         
        $this->view->makeListPage($this->accountStore->readAll());
    }
    
    //getter de la base de donnée
    public function getStorage(){
        return $this->getStorage;
    }
    //authentification
    //enregistrer un article
    // public function saveNewAnimal(array $data){         
    //     //edition d'un nouveau animal
    //     $animalBuilder = new AnimalBuilder($data);                
    //     if($animalBuilder->isValid()){            
    //         $key = $animalBuilder->createAnimal($this->animalTab); 
    //        $this->view->makeDebugPage($key);           
    //     }                
    //     else{
    //         //print the form with errors
    //         $this->view->makeAnimalCreationPage($animalBuilder); 
            
    //     }
    // }
}

?>
