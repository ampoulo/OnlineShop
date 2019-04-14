<?php 

    set_include_path("./src");
    
class ArticleStorage /*implements Storage*/{
    
    private $db;
    

    //recupérer un article spécifié
    function read($id){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("SELECT * FROM articles where idArticle = ?");
        $data=array($id);
        $query->execute($data);

        $ligne = $query->fetchAll();        
        return ($ligne)?(Article::initialize($ligne[0])):false;
    }
        //toutes les lignes de $idAccount
        public function readAll2($idAccount) {
            $connexion = SqlTool::getInstance()->getConnexion();
            $query = $connexion->prepare("SELECT  * FROM articles, Panier, account WHERE  Panier.idAccount=account.idAccount and Panier.idArticle=articles.idArticle and Panier.idAccount = :idAccount");
            $query->bindValue(':idAccount',$idAccount, PDO::PARAM_INT);
            $query->execute();
    
            $articleList = array();
            foreach ($query->fetchall() as $id => $articleData) {
                $article = Article::initialize($articleData);
                $articleList[$id] = $article;
            }
	        return $articleList;
        }
    //recupérer tous les articles
    function readAll(){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("SELECT * FROM articles");
        $query->execute();
        //var_dump($query->fetchAll());
        $articleList = array();
        foreach ($query->fetchall() as $id => $articleData) {
            $article = Article::initialize($articleData);
            $articleList[$id] = $article;
        }
	return $articleList;
                
        //return ArticleList::initialize($query->fetchall());
    }
    //créer un article par administrateur
    public function create(Article $a){
        $connexion = SqlTool::getInstance()->getConnexion();
        $insert = "INSERT INTO Article VALUES ($a->id, $a->image, $a->couleur,$a->taille,$a->prix)";
        $query = $connexion->prepare($insert);
        $query->execute();
    }
    
    //supprimer un article de la base
    public function delete($id){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("DELETE FROM articles WHERE idArticle=? ");
        $data=array($id);        
        return $query->execute($data);
    }

    public function deleteAll() {
        
    }

    public function update() {
        
    }

}