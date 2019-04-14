<?php

class TipsModel {

    private $id = -1;
    private $langage = "";
    private $content = "";

    function __construct($id, $langage, $content) {
        $this->id = $id;
        $this->langage = $langage;
        $this->content = $content;
    }

    public static function initialize($data = array()) {
        // time to do security verification
        //var_dump($data);
        $id = $data["id"];
        $langage = $data["langage"];
        $content = $data["content"];

        return new TipsModel($id, $langage, $content);
    }

    function getId() {
        return $this->id;
    }

    function getLangage() {
        return $this->langage;
    }

    function getContent() {
        return $this->content;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLangage($langage) {
        $this->langage = $langage;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
