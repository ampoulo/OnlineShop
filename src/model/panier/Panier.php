<?php


// Créer une classe Account qui représente un compte utilisateur (nom, login, mot de passe et statut).
class Panier{
    private $idPanier;
    private $idAccount;
    private $idArticle;
    
    function __construct($idPanier=0,$idAccount,$idArticle){
        $this->$idPanier=$idPanier;
        $this->idAccount=$idAccount;
        $this->$idArticle = $idArticle;
    }

    //initialisation des donnant venant de la base de données
    public static function initialize($data = array()) {
        // time to do security verification
        //var_dump($data);
        $idPanier=$data['idPanier'];
        $idAccount=$data['idAccount'];
        $idArticle=$data['idArticle'];         
        return new Panier($idAccount,$idArticle);
    }

  
    //getters
    public function getIdAccount(){
        return $this->idAccount;
    }
    public function getIdPanier(){
        return $this->idPanier;
    }

    public function getIdArticle(){
        return $this->idArticle;
    }
}
