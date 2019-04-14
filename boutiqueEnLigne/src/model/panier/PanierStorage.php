<?php

set_include_path("./");
class PanierStorage /*implements Storage*/{
    


    public function create($idAccount,$idArticle){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare('insert into Panier values (null, :idAccount, :idArticle)');
        $query->bindValue(':idAccount', $idAccount, PDO::PARAM_INT);
        $query->bindValue(':idArticle', $idArticle, PDO::PARAM_INT);
        $query->execute();
        return 1;
    }

    public function readArticl($idAccount,$idArticle){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare('select distinct idArticle, idPanier from Panier where idAccount = :idAccount, idArticle :idArticle)');
        $query->bindValue(':idAccount', $idAccount, PDO::PARAM_INT);
        $query->bindValue(':idArticle', $idArticle, PDO::PARAM_INT);
        $query->execute();
    }
    public function delete($idPanier) {
        //var_dump($idArticle);
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("DELETE FROM Panier WHERE idPanier = :idPanier");
        $query->bindValue(':idPanier',$idPanier,PDO::PARAM_INT);
        $query->execute();
        
    }

    public function deleteAll() {
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("DELETE FROM panier WHERE idAccount= ? and idArticle= ?");
        $query->execute(array($idAccount,$idArticle));
        return 1;        
    }
   
    public function read($id) {  
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select * from Panier where idPanier = ?");
        $data=array($id);
        $query->execute($data);

        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        return Panier::initialize($ligne);
    }
     
    public function read2($idArticle) {  
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("select idPanier from Panier,articles where Panier.idArticle=articles.idArticle and  articles.idArticle= :idArticle");
        $query->bindValue(':idArticle',$idArticle, PDO::PARAM_INT);
        $query->execute();
        $idPanier=$query->fetch(PDO::FETCH_ASSOC);   
        //var_dump($idPanier);     
        return $idPanier['idPanier'];
    }
    //toutes les lignes de $idAccount
    public function count($idAccount) {
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("SELECT count(*) FROM Panier where idAccount = :idAccount");
        $query->bindValue(':idAccount', $idAccount, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['count(*)'];
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

