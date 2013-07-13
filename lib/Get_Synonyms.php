<?php
    class Get_Synonyms extends Curl
    {
        const URL = "http://words.bighugelabs.com/api/2/8649068e63c10fe14915abd53482709c/";
        public function getSynonyms($word){
            return $this->getResponse(Get_Synonyms::URL.$word."/json");
        }
    }
?>