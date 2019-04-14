<?php

set_include_path("./");
class AccountStorage /*implements Storage*/{
    


    public function create(Account $account) {
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("insert into account values (null, :mail, :password, :name)");
        $query->bindValue(':mail',$account->getMail(),PDO::PARAM_STR);
        $query->bindValue(':password',password_hash($account->getPassword(),PASSWORD_BCRYPT),PDO::PARAM_STR);
        $query->bindValue(':name',$account->getNom(),PDO::PARAM_STR);
        $query->execute();
    }

    public function delete($id) {
    }

    public function deleteAll() {
        
    }
    public function login(){
        
    }
    
      //utilisée pour l'authentification de l'utilisateur
    public function checkAuth($mail,$password){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select * from account where mail = ?");
        $data=array($mail);
        $query->execute($data);
        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        //vérifie si les renseignements figure dans la base de données
        if(password_verify($password,$ligne['password'])){                
            return Account::initialize($ligne); 
        }                             
        return false;
    }   
    public function checkLoginExistence($mail){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select mail from account where mail = ?");
        $data=array($mail);
        $query->execute($data);
        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        //vérifie si les renseignements figure dans la base de données
        return $ligne;
    }
    public function read($id) {  
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select * from account where idAccount =:id");
        $data=array(':id' => $id);
        $query->execute($data);        
        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        return ($ligne)?Account::initialize($ligne):null;
    }
   
    public function readAll() {
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select * from account");
        //$data=array('id' => $id);
        $query->execute($data);
    }

    public function update() {
        
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

