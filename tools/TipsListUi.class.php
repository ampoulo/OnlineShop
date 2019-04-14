<?php

class TipsListUi {

    protected $tipsList;

    public function __construct(TipsListModel $tipsList) {
        $this->tipsList = $tipsList;
    }

    public function toHtml() {
        $return = '';
        foreach($this->tipsList->getTipsList() as $tips){
            $tipsUi = new TipsUi($tips);
            $return .= $tipsUi->toHtml();
        }
        return "<div>" . $return .  "</div>";
    }

}
