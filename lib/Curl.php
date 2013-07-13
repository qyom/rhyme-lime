<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sargis
 * Date: 7/13/13
 * Time: 9:20 PM
 * To change this template use File | Settings | File Templates.
 */
class Curl
{
    protected $url = '';
    protected $ch = null;
    public function getResponse($url){
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($this->ch);
        return $response;
    }
}
