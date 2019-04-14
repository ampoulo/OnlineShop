<?php

class Article{
    private $id;
    private $titre;
    private $description;
    private $image;
    private $couleur;
    private $taille;
    private $prix;

    public function __construct($id,$titre,$description,$image, $couleur, $taille, $prix){
        $this->id = $id; 
        $this->titre = $titre;
        $this->description=$description;
        $this->image=$image;
        $this->couleur=$couleur;
        $this->prix=$prix;
        $this->taille = $taille;
    }
    //initialisation des donnant venant de la base de données
    public static function initialize($data=array()) {
        // time to do security verification
        $id = $data['idArticle'];
        $titre = $data["titre"];    
        $description = $data["description"];  
        $image=$data['image'];
        $couleur = $data["couleur"];
        $taille = $data["taille"];
        $prix = $data["prix"];            
                
        return new Article($id,$titre,$description,$image, $couleur, $taille, $prix);
    }
    
    //getters
     public function getId(){
        return $this->id;    
    }
      public function getTitre(){
        return $this->titre;    
    }  
    public function getDescription(){
        return $this->description;    
    }
    public function getImage(){
        return $this->image;    
    }
    public function getCouleur(){
        return $this->couleur;
    }
    public function getTaille(){
        return $this->taille;
    }
    public function getPrix(){
        return $this->prix;
    }

    //setters
    public function setImage($image){
        $this->image = $image;
    }
    public function setTaille($taille){
        $this->taille = $taille;
    } 
    public function setPrix($prix){
        $this->prix = $prix;
    }
    public function setCouleur($couleur){
        $this->couleur = $couleur;
    }
}