<?php
    class Get_Rhymebrain extends Curl
    {
        const URL = "http://rhymebrain.com/talk?function=getRhymes&word=";
        public function getRhymes($word){
            return $this->getResponse(Get_Rhymebrain::URL.$word);
        }
    }
?>