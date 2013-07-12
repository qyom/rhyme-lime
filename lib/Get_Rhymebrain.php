<?php
    class Get_Rhymebrain
    {
        const URL = "http://rhymebrain.com/talk?function=getRhymes&word=";
        protected $ch = null;
        public function getRhymes($word){
            $this->ch = curl_init();
            curl_setopt($this->ch, CURLOPT_URL, Get_Rhymebrain::URL.$word);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($this->ch);
            return $response;
        }
    }
?>