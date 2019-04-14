<?php

class TipsUi {

    protected $tips;

    public function __construct(TipsModel $tips) {
        $this->tips = $tips;
    }

    public function toHtml() {
        return "<div><a href=\"?q=view/tips/" . $this->tips->getId() . "\">" .
        "<div>" . $this->tips->getId() . "</div>" .
        $this->tips->getLangage() ." | ".
        $this->tips->getContent() ."</a></div";
    }

}
