<?php 

    set_include_path("./src");
    
class ArticleStorageDB implements Storage{
    
    private $db;

    function __construct(SqlConnexion $db){
        $this->db = $db;
    }

    //recupérer un article spécifié
    function read($id){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("SELECT * FROM articles WHERE id=:id");
        $data=array('id' => $id);
        $query->execute($data);

        $ligne = $query->fetch(PDO::FETCH_ASSOC);
        return Article::initialize($ligne);
    }
    //recupérer tous les articles
    function readAll(){
        $connexion = SqlTool::getInstance()->getConnexion();
        $query = $connexion->prepare("SELECT * FROM articles");
        $query->execute();
        return ArticleList::initialize($query->fetchall());
    }
    //créer un article par administrateur
    public function create(Article $a){
        $insert = "INSERT INTO Article VALUES ($a->id, $a->image, $a->couleur,$a->taille,$a->prix)";
        $this->db->prepare($insert);
        $this->db->execute();
    }
    //supprimer un article de la base
    public function delete($id) {
        $del = "";
    }

    public function deleteAll() {
        
    }

    public function update() {
        
    }

}