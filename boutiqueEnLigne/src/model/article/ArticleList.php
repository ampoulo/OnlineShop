<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ArticleListSQL{
    
    
    private $articleList = array();
    
    public function __construct($articleList){
        $this->articleList = ArticleList;            
    }
    
    public static function initialize($data){
        $articleList = array();
        foreach ($data as $id => $articleData) {
            $article = Article::initialize($articleData);
            $articleList[] = $article;
        }
	       return new self($articleList);
        
    }
    
    public function getArticleList(){
        return $this->articleList;        
    }
}

