<?php


// Créer une classe Account qui représente un compte utilisateur (nom, login, mot de passe et statut).
class Account{
    private $id;
    private $nom;
    private $mail;
    private $mot_de_passe;

    function __construct($id, $nom, $mail, $mot_de_passe){
        $this->id=$id;
        $this->nom = $nom;
        $this->mail=$mail;
        $this->mot_de_passe = $mot_de_passe;        
    }

    //initialisation des donnant venant de la base de données
    public static function initialize($data = array()) {
        // time to do security verification
        //var_dump($data);
        $id=$data['idAccount'];
        $nom = $data['name'];
        $mail=$data['mail'];
        $mot_de_passe = $data['password']; 
        return new Account($id, $nom, $mail, $mot_de_passe);
    }

  
    //getters
    public function getId(){
        return $this->id;   
    }
    public function getNom(){
        return $this->nom;
    }

    public function getMail(){
        return $this->mail;
    }

    public function  getPassword(){
        return $this->mot_de_passe;
    }

    public function getStatut(){
        return $this->statut;
    }

    //setters
    public function setNom($nom){
        $this->nom=$nom;
    }

    public function setLogin($login){
        $this->login=$login;
    }

    public function setMot_de_passe($mot_de_passe){
        $this->mot_de_passe=$mot_de_passe;
    }

    public function setStatut(){
        $this->statut=$statut;
    }
}
