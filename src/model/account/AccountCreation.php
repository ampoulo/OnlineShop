<?php

class AccountCreation{

    private $data;
    private $error;
    //la base de données
    private $accountStorage;
    
    const NAME= "nom";
    const MAIL= "mail";
    const PASSWD= "password";


    public function __construct($data=null){
     /* Crée une nouvelle instance, avec les données passées en argument si
 	 * elles existent, et sinon avec
 	 * les valeurs par défaut des champs de création d'une couleur. */
		if ($data === null || $data===array()) {
			$data = array(
				"nom" => "",				
                "mail" => "",
                "password" => "",
			);
		}
		$this->data = $data;
		$this->error = array(
            "nom" => null,				
            "mail" => null,
            "password" => null,
            'loginOuPasswdIncorrect'=>null,
        );
	}

    
      


    //crée un compte à partir des donnée du formulaire
    public function createAccount(AccountStorage $accountStorage){  
            $new_account = new Account(0,$this->data[self::NAME],$this->data[self::MAIL],$this->data[self::PASSWD]);
            if($accountStorage->checkLoginExistence($new_account->getMail())===false){                
                return $new_account;
            }
            $this->error['loginExistence']='ce mail existe déja veuillez en choisir un autre!';
            return false;
    }
    //verifie la validité du formulaire remplit par l'utilisateur
    public function isValid(){                               
        if(key_exists(self::NAME,$this->data) && $this->data[self::NAME]==='' ){
            $this->error[self::NAME]="<p>remplir votre <strong>nom</strong></p>";}
        // }else{
        //     $this->error[self::NAME]=null;
        // }
        if(key_exists(self::MAIL,$this->data) && $this->data[self::MAIL]===''){
            $this->error[self::MAIL] = "remplir votre <strong>adresse mail</strong>";}
        // }else {
        //     $this->error[self::MAIL]=null;
        // }
        if(key_exists(self::PASSWD,$this->data) && $this->data[self::PASSWD]===''){
            $this->error[self::PASSWD] = "<strong>mot de passe requis </strong>";}
        // }else {
        //     $this->error[self::PASSWD]=null;
        // }
        // if(!key_exists(self::MAIL,$this->data) || $this->data[self::MAIL]===''){
        //     $this->error[self::MAIL] = "remplir votre <strong>prenom</strong>";
        // }else {
        //     $this->error[self::MAIL]=null;
        // }
        // if(!key_exists(self::AGE_REF,$this->data) || $this->data[self::AGE_REF]==='')
        //     $this->error[self::AGE_REF]='fill the<strong> age </strong>field';
        // else if(intval($this->data[self::AGE_REF])<0){
        //      $this->error[self::AGE_REF]="enter a positive number ";
        // }else {
        //         $this->error[self::AGE_REF]=null;
        // }            
        foreach($this->error as $key=>$val){
            //si le tableau d'erreur n'est pas vide, retourner faux;
            if($val!==null)
                return false;
        }
        return true;
        
    }


    //getters
    public function getData($data){
        return $this->data[$data];   
    }
    public function getDatat(){
        return $this->data;
    }
    public function getError($data){
        return $this->error[$data];
    }
    
    public function getErrtable(){
        return $this->error;    
    }
    
    //setters    
    public function setdata($data){
        $this->data = $data;
    } 
    public function setError($error){
        $this->error = $error;
    }
    public function addError($id,$error){
        $this->error[$id]=$error;
    }

}